<?php
namespace App\Models;
use PDO;

class AdminModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    // =========================================================================
    // 1. MANAJEMEN PENGGUNA (USER MANAGEMENT)
    // =========================================================================
    
    public function getUsers($search = '', $jurusanId = null) {
        $sql = "SELECT u.*, j.nama_jurusan FROM users u LEFT JOIN master_jurusan j ON u.jurusan_id = j.id WHERE 1=1";
        $params = [];

        if ($search) {
            $sql .= " AND (u.username LIKE :s OR u.email LIKE :s)";
            $params['s'] = "%$search%";
        }
        if ($jurusanId) {
            $sql .= " AND u.jurusan_id = :j";
            $params['j'] = $jurusanId;
        }
        $sql .= " ORDER BY u.id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        // Hash password dilakukan di Controller, data mentah masuk sini
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role, jurusan_id, is_active) VALUES (?, ?, ?, ?, ?, 1)");
        return $stmt->execute([
            $data['username'], $data['email'], $data['password'], $data['role'], $data['jurusan_id']
        ]);
    }

    public function softDeleteUser($id) {
        $stmt = $this->db->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // =========================================================================
    // 2. MASTER DATA (JURUSAN & IKU) - Penambal Error 500
    // =========================================================================

    public function getAllJurusan() {
        return $this->db->query("SELECT * FROM master_jurusan ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllIku() {
        return $this->db->query("SELECT * FROM master_iku ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================================================================
    // 3. AUDIT LOG & KEAMANAN
    // =========================================================================

    public function getAuditLogs($filters = [], $page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT l.*, u.username FROM log_audit_sistem l JOIN users u ON l.user_id = u.id WHERE 1=1";
        $params = [];

        if (!empty($filters['user'])) {
            $sql .= " AND u.username LIKE :user";
            $params['user'] = "%{$filters['user']}%";
        }
        if (!empty($filters['action'])) {
            $sql .= " AND l.aksi LIKE :action";
            $params['action'] = "%{$filters['action']}%";
        }
        if (!empty($filters['date'])) {
            $sql .= " AND DATE(l.timestamp) = :date";
            $params['date'] = $filters['date'];
        }

        $sql .= " ORDER BY l.timestamp DESC LIMIT :offset, :perPage";
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', (int)$perPage, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllLogsForExport() {
        return $this->db->query("SELECT l.timestamp, u.username, l.aksi, l.ip_address FROM log_audit_sistem l JOIN users u ON l.user_id = u.id ORDER BY l.timestamp DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
}