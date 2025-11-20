<?php
// app/Controllers/UsulanController.php
namespace App\Controllers;

use PDO;

class UsulanController
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function detail($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $stmt = $this->db->prepare("SELECT u.*, us.username FROM usulan_kegiatan u JOIN users us ON u.user_id = us.id WHERE u.id = :id");
        $stmt->execute(['id' => $id]);
        $usulan = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$usulan) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            exit;
        }
        // Log histori
        $logStmt = $this->db->prepare("SELECT l.*, us.username FROM log_histori_usulan l JOIN users us ON l.user_id = us.id WHERE l.usulan_id = :id ORDER BY l.timestamp DESC");
        $logStmt->execute(['id' => $id]);
        $logs = $logStmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../Views/usulan/detail.php';
    }
}
