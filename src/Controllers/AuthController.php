<?php
require_once __DIR__ . '/../../config/database.php';

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password) {
        try {
            $stmt = $this->db->prepare('SELECT u.*, r.name as role_name FROM users u 
                                       JOIN roles r ON u.role_id = r.id 
                                       WHERE u.username = ? AND u.is_active = true');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role_name'];
                $_SESSION['full_name'] = $user['full_name'];
                
                return ['success' => true];
            }
            return ['success' => false, 'message' => 'Invalid credentials'];
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred during login'];
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /NHSL_DMS/public/');
        exit;
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public function hasRole($role) {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }
}