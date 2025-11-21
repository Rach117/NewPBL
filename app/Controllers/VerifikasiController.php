<?php
namespace App\Controllers;

use PDO;

class VerifikasiController
{
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function index($page = 1, $perPage = 10)
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Verifikator') {
            header('Location: /login'); exit;
        }

        // PERUBAHAN: Verifikasi TELAAH, bukan USULAN
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare("
            SELECT t.*, u.username,
                   (SELECT SUM(total) FROM telaah_rab WHERE telaah_id = t.id) as total_anggaran
            FROM telaah_kegiatan t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.status_telaah = 'Diajukan' 
            ORDER BY t.created_at DESC 
            LIMIT :offset, :perPage
        ");
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', (int)$perPage, PDO::PARAM_INT);
        $stmt->execute();
        $telaah = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->db->query("SELECT COUNT(*) FROM telaah_kegiatan WHERE status_telaah = 'Diajukan'")->fetchColumn();

        require __DIR__ . '/../Views/verifikasi/index.php';
    }

    public function proses($id)
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Verifikator') {
            header('Location: /login'); exit;
        }

        // PERUBAHAN: Ambil TELAAH
        $stmt = $this->db->prepare("
            SELECT t.*, u.username,
                   (SELECT SUM(total) FROM telaah_rab WHERE telaah_id = t.id) as total_anggaran
            FROM telaah_kegiatan t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $telaah = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$telaah) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        // Ambil detail RAB
        $rab = $this->db->prepare("
            SELECT tr.*, mk.nama_kategori 
            FROM telaah_rab tr 
            JOIN master_kategori_anggaran mk ON tr.kategori_id = mk.id 
            WHERE tr.telaah_id = :id
        ");
        $rab->execute(['id' => $id]);
        $rab_items = $rab->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/verifikasi/proses.php';
    }

    public function aksi($id)
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Verifikator') exit;

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Security Alert: Invalid CSRF Token.');
        }

        $aksi = $_POST['aksi'] ?? '';
        $catatan = trim($_POST['catatan'] ?? '');
        $kode_mak = trim($_POST['kode_mak'] ?? '');
        $userId = $_SESSION['user_id'];

        // PERUBAHAN: Update status TELAAH
        $statusBaru = '';
        if ($aksi === 'setuju') {
            $statusBaru = 'Disetujui';
        } elseif ($aksi === 'revisi') {
            $statusBaru = 'Revisi';
        } elseif ($aksi === 'tolak') {
            $statusBaru = 'Ditolak';
        }

        // Update telaah
        $stmt = $this->db->prepare("
            UPDATE telaah_kegiatan 
            SET status_telaah = :status, catatan_verifikator = :catatan 
            WHERE id = :id
        ");
        $stmt->execute(['status' => $statusBaru, 'catatan' => $catatan, 'id' => $id]);

        // Notifikasi ke pengusul
        $telaah = $this->db->prepare("SELECT user_id, nama_kegiatan FROM telaah_kegiatan WHERE id = :id");
        $telaah->execute(['id' => $id]);
        $t = $telaah->fetch(PDO::FETCH_ASSOC);

        $judul = "Telaah $statusBaru";
        $pesan = "Telaah '{$t['nama_kegiatan']}' telah $statusBaru oleh Verifikator.";
        $link = "/telaah/list";

        $this->db->prepare("INSERT INTO notifikasi (user_id, judul, pesan, link) VALUES (?, ?, ?, ?)")
                 ->execute([$t['user_id'], $judul, $pesan, $link]);

        $_SESSION['toast'] = ['type' => 'success', 'msg' => "Telaah berhasil $statusBaru!"];
        header('Location: /verifikasi');
        exit;
    }
}