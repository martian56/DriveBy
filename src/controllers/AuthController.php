<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $user;
    
    public function __construct() {
        $this->user = new User();
    }
    
    public function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'All fields are required.';
                return false;
            }
            
            if (strlen($username) < 3) {
                $_SESSION['error'] = 'Username must be at least 3 characters.';
                return false;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email address.';
                return false;
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters.';
                return false;
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match.';
                return false;
            }
            
            if ($this->user->usernameExists($username)) {
                $_SESSION['error'] = 'Username already exists.';
                return false;
            }
            
            if ($this->user->emailExists($email)) {
                $_SESSION['error'] = 'Email already exists.';
                return false;
            }
            
            $userId = $this->user->register($username, $email, $password);
            
            if ($userId) {
                $_SESSION['success'] = 'Registration successful! Please login.';
                header('Location: index.php?page=login');
                exit;
            } else {
                $_SESSION['error'] = 'Registration failed. Please try again.';
                return false;
            }
        }
        return false;
    }
    
    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username/email and password are required.';
                return false;
            }
            
            $user = $this->user->login($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['success'] = 'Welcome back, ' . $user['username'] . '!';
                header('Location: index.php?page=dashboard');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid username/email or password.';
                return false;
            }
        }
        return false;
    }
    
    public function handleLogout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            header('Location: index.php?page=login');
            exit;
        }
    }
}

