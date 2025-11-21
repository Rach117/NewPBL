<?php
namespace App\Controllers;

use PDO;

class TelaahController
{
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Halaman list telaah milik user
    public function list()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Pengusul') {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        // Ambil semua telaah milik user
        $stmt = $this->db->prepare("
            SELECT t.*, 
                   (SELECT SUM(total) FROM telaah_rab WHERE telaah_id = t.id) as total_anggaran
            FROM telaah_kegiatan t 
            WHERE t.user_id = :uid 
            ORDER BY t.updated_at DESC
        ");
        $stmt->execute(['uid' => $userId]);
        $telaah_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require __DIR__ . '/../Views/telaah/list.php';
    }

    // Form create/edit telaah (wizard)
    public function create()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Pengusul') {
            header('Location: /login');
            exit;
        }

        $telaahId = $_GET['id'] ?? null;
        $telaah = null;
        $indikators = [];
        $ikus = [];
        $rabs = [];

        // Jika edit, load data existing
        if ($telaahId) {
            $stmt = $this->db->prepare("SELECT * FROM telaah_kegiatan WHERE id = :id AND user_id = :uid");
            $stmt->execute(['id' => $telaahId, 'uid' => $_SESSION['user_id']]);
            $telaah = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($telaah) {
                // Load indikator
                $indikators = $this->db->prepare("SELECT * FROM indikator_kinerja WHERE telaah_id = :id");
                $indikators->execute(['id' => $telaahId]);
                $indikators = $indikators->fetchAll(PDO::FETCH_ASSOC);
                
                // Load IKU
                $ikus = $this->db->prepare("SELECT * FROM telaah_iku WHERE telaah_id = :id");
                $ikus->execute(['id' => $telaahId]);
                $ikus = $ikus->fetchAll(PDO::FETCH_ASSOC);
                
                // Load RAB
                $rabs = $this->db->prepare("SELECT tr.*, mk.nama_kategori 
                                           FROM telaah_rab tr 
                                           JOIN master_kategori_anggaran mk ON tr.kategori_id = mk.id 
                                           WHERE tr.telaah_id = :id");
                $rabs->execute(['id' => $telaahId]);
                $rabs = $rabs->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        // Master data untuk dropdown
        $master_iku = $this->db->query('SELECT * FROM master_iku ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
        $kategori = $this->db->query('SELECT * FROM master_kategori_anggaran ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/telaah/wizard.php';
    }

    // AJAX: Save draft
    public function saveDraft()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Pengusul') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        // Validasi CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            exit;
        }

        try {
            $this->db->beginTransaction();

            $userId = $_SESSION['user_id'];
            $telaahId = $_POST['telaah_id'] ?? null;
            
            // Data Step 1: KAK
            $data = [
                'user_id' => $userId,
                'nama_kegiatan' => $_POST['nama_kegiatan'] ?? '',
                'gambaran_umum' => $_POST['gambaran_umum'] ?? '',
                'penerima_manfaat' => $_POST['penerima_manfaat'] ?? '',
                'strategi_pencapaian' => $_POST['strategi_pencapaian'] ?? '',
                'metode_pelaksanaan' => $_POST['metode_pelaksanaan'] ?? '',
                'tahapan_pelaksanaan' => $_POST['tahapan_pelaksanaan'] ?? '',
                'tanggal_mulai' => $_POST['tanggal_mulai'] ?? null,
                'tanggal_selesai' => $_POST['tanggal_selesai'] ?? null,
            ];

            if ($telaahId) {
                // Update existing
                $sql = "UPDATE telaah_kegiatan SET 
                        nama_kegiatan = :nama_kegiatan,
                        gambaran_umum = :gambaran_umum,
                        penerima_manfaat = :penerima_manfaat,
                        strategi_pencapaian = :strategi_pencapaian,
                        metode_pelaksanaan = :metode_pelaksanaan,
                        tahapan_pelaksanaan = :tahapan_pelaksanaan,
                        tanggal_mulai = :tanggal_mulai,
                        tanggal_selesai = :tanggal_selesai
                        WHERE id = :id AND user_id = :user_id";
                $stmt = $this->db->prepare($sql);
                $data['id'] = $telaahId;
                $stmt->execute($data);
            } else {
                // Insert new
                $sql = "INSERT INTO telaah_kegiatan 
                        (user_id, nama_kegiatan, gambaran_umum, penerima_manfaat, strategi_pencapaian, 
                         metode_pelaksanaan, tahapan_pelaksanaan, tanggal_mulai, tanggal_selesai, status_telaah) 
                        VALUES 
                        (:user_id, :nama_kegiatan, :gambaran_umum, :penerima_manfaat, :strategi_pencapaian, 
                         :metode_pelaksanaan, :tahapan_pelaksanaan, :tanggal_mulai, :tanggal_selesai, 'Draft')";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($data);
                $telaahId = $this->db->lastInsertId();
            }

            // Save Indikator Kinerja
            if (isset($_POST['indikator_keberhasilan']) && is_array($_POST['indikator_keberhasilan'])) {
                // Hapus yang lama
                $this->db->prepare("DELETE FROM indikator_kinerja WHERE telaah_id = ?")->execute([$telaahId]);
                
                // Insert yang baru
                $stmt = $this->db->prepare("INSERT INTO indikator_kinerja (telaah_id, indikator_keberhasilan, bulan_target, bobot_persen) VALUES (?, ?, ?, ?)");
                foreach ($_POST['indikator_keberhasilan'] as $i => $indikator) {
                    if (!empty($indikator)) {
                        $stmt->execute([
                            $telaahId,
                            $indikator,
                            $_POST['bulan_target'][$i] ?? null,
                            $_POST['bobot_persen'][$i] ?? null
                        ]);
                    }
                }
            }

            // Save IKU
            if (isset($_POST['iku_ids']) && is_array($_POST['iku_ids'])) {
                $this->db->prepare("DELETE FROM telaah_iku WHERE telaah_id = ?")->execute([$telaahId]);
                
                $stmt = $this->db->prepare("INSERT INTO telaah_iku (telaah_id, iku_id, target_value) VALUES (?, ?, ?)");
                foreach ($_POST['iku_ids'] as $i => $ikuId) {
                    if (!empty($ikuId)) {
                        $stmt->execute([
                            $telaahId,
                            $ikuId,
                            $_POST['iku_targets'][$i] ?? null
                        ]);
                    }
                }
            }

            // Save RAB
            if (isset($_POST['rab_kategori']) && is_array($_POST['rab_kategori'])) {
                $this->db->prepare("DELETE FROM telaah_rab WHERE telaah_id = ?")->execute([$telaahId]);
                
                $stmt = $this->db->prepare("INSERT INTO telaah_rab (telaah_id, kategori_id, uraian, volume, satuan, harga_satuan, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
                foreach ($_POST['rab_kategori'] as $i => $kategoriId) {
                    if (!empty($kategoriId)) {
                        $volume = $_POST['rab_volume'][$i] ?? 0;
                        $harga = $_POST['rab_harga'][$i] ?? 0;
                        $total = $volume * $harga;
                        
                        $stmt->execute([
                            $telaahId,
                            $kategoriId,
                            $_POST['rab_uraian'][$i] ?? '',
                            $volume,
                            $_POST['rab_satuan'][$i] ?? 'unit',
                            $harga,
                            $total
                        ]);
                    }
                }
            }

            $this->db->commit();
            
            echo json_encode([
                'success' => true, 
                'message' => 'Draft berhasil disimpan',
                'telaah_id' => $telaahId
            ]);
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }

    // Submit telaah ke verifikator
    public function submit()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Pengusul') {
            header('Location: /login');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }

        $telaahId = $_POST['telaah_id'] ?? null;
        
        if (!$telaahId) {
            $_SESSION['toast'] = ['type' => 'error', 'msg' => 'Telaah ID tidak valid'];
            header('Location: /telaah/list');
            exit;
        }

        // Validasi telaah milik user
        $stmt = $this->db->prepare("SELECT * FROM telaah_kegiatan WHERE id = :id AND user_id = :uid");
        $stmt->execute(['id' => $telaahId, 'uid' => $_SESSION['user_id']]);
        $telaah = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$telaah) {
            $_SESSION['toast'] = ['type' => 'error', 'msg' => 'Telaah tidak ditemukan'];
            header('Location: /telaah/list');
            exit;
        }

        // Update status
        $stmt = $this->db->prepare("UPDATE telaah_kegiatan SET status_telaah = 'Diajukan' WHERE id = :id");
        $stmt->execute(['id' => $telaahId]);

        // Notifikasi ke semua verifikator
        $verifikators = $this->db->query("SELECT id FROM users WHERE role = 'Verifikator' AND is_active = 1")->fetchAll(PDO::FETCH_ASSOC);
        $notifStmt = $this->db->prepare("INSERT INTO notifikasi (user_id, judul, pesan, link) VALUES (?, ?, ?, ?)");
        
        foreach ($verifikators as $verif) {
            $notifStmt->execute([
                $verif['id'],
                'Pengajuan Telaah Baru',
                "Telaah '{$telaah['nama_kegiatan']}' menunggu verifikasi Anda.",
                '/verifikasi'
            ]);
        }

        $_SESSION['toast'] = ['type' => 'success', 'msg' => 'Telaah berhasil diajukan ke Verifikator!'];
        header('Location: /telaah/list');
        exit;
    }

    // Delete draft telaah
    public function delete()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Pengusul') {
            header('Location: /login');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }

        $telaahId = $_POST['id'] ?? null;
        
        // Hanya bisa hapus jika status Draft atau Ditolak
        $stmt = $this->db->prepare("DELETE FROM telaah_kegiatan WHERE id = :id AND user_id = :uid AND status_telaah IN ('Draft', 'Ditolak')");
        $stmt->execute(['id' => $telaahId, 'uid' => $_SESSION['user_id']]);

        $_SESSION['toast'] = ['type' => 'success', 'msg' => 'Draft telaah berhasil dihapus'];
        header('Location: /telaah/list');
        exit;
    }
}