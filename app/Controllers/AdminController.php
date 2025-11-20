<?php
namespace App\Controllers;

use App\Models\AdminModel; 
use PDO;

class AdminController
{
    private $db;
    public function __construct($db) { $this->db = $db; }

    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
            header('Location: /login'); exit;
        }
    }

    // --- MANAJEMEN PENGGUNA ---
    public function users() {
        $this->checkAdmin();
        
        $model = new AdminModel($this->db);
        // Filter pencarian dan jurusan
        $users = $model->getUsers($_GET['search'] ?? '', $_GET['jurusan'] ?? '');
        // Dropdown filter butuh data jurusan
        $jurusan = $model->getAllJurusan(); 
        
        require __DIR__ . '/../Views/admin/users.php';
    }

    public function createUser() {
        $this->checkAdmin();
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) die('Invalid Security Token');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username'   => $_POST['username'],
                'email'      => $_POST['email'],
                'password'   => password_hash($_POST['password'], PASSWORD_BCRYPT),
                'role'       => $_POST['role'],
                'jurusan_id' => !empty($_POST['jurusan_id']) ? $_POST['jurusan_id'] : null
            ];

            $model = new AdminModel($this->db);
            try {
                $model->createUser($data);
                $_SESSION['toast'] = ['type' => 'success', 'msg' => 'User berhasil ditambahkan'];
            } catch (\Exception $e) {
                $_SESSION['toast'] = ['type' => 'error', 'msg' => 'Username/Email sudah ada!'];
            }
            header('Location: /users');
            exit;
        }
    }

    public function deleteUser() {
        $this->checkAdmin();
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) die('Invalid Security Token');

        $id = $_POST['id'] ?? 0;
        $model = new AdminModel($this->db);
        $model->softDeleteUser($id);
        
        $_SESSION['toast'] = ['type' => 'success', 'msg' => 'User dinonaktifkan (Soft Delete)'];
        header('Location: /users');
        exit;
    }

    // --- MASTER DATA CONTROLS ---
    
    public function indexMaster() {
        $this->checkAdmin();
        require __DIR__ . '/../Views/admin/master_landing.php';
    }

    public function iku() {
        $this->checkAdmin();
        $model = new AdminModel($this->db);
        $iku = $model->getAllIku(); // Memanggil method di AdminModel
        require __DIR__ . '/../Views/admin/iku.php';
    }

    public function jurusan() {
        $this->checkAdmin();
        $model = new AdminModel($this->db);
        $jurusan = $model->getAllJurusan(); // Memanggil method di AdminModel
        require __DIR__ . '/../Views/admin/jurusan.php';
    }
}