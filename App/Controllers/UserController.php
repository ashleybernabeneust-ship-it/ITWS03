<?php
namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use App\Controllers\ErrorController;

class UserController {
    protected $db;

    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function create($params = []) {
        loadView('Users/register', ['user' => [], 'errors' => []]);
    }

    public function store($params = []) {
        Session::start();

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? ''
        ];

        $errors = [];

        if ($data['name'] === '') {
            $errors[] = 'Name is required.';
        }
        if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email address is required.';
        }
        if ($data['city'] === '') {
            $errors[] = 'City is required.';
        }
        if ($data['state'] === '') {
            $errors[] = 'State is required.';
        }
        if ($data['password'] === '') {
            $errors[] = 'Password is required.';
        }
        if ($data['password'] !== $data['password_confirmation']) {
            $errors[] = 'Password confirmation does not match.';
        }

        if (empty($errors)) {
            $existingUser = $this->db->Query(
                "SELECT id FROM users WHERE email = :email",
                ['email' => $data['email']]
            )->fetch();

            if ($existingUser) {
                $errors[] = 'Email is already registered.';
            }
        }

        if (!empty($errors)) {
            loadView('Users/register', ['errors' => $errors, 'user' => $data]);
            return;
        }

        $this->db->Query(
            "INSERT INTO users (name, email, city, state, password) VALUES (:name, :email, :city, :state, :password)",
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'city' => $data['city'],
                'state' => $data['state'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]
        );

        $userId = $this->db->conn->lastInsertId();

        Session::set('user', [
            'id' => $userId,
            'name' => $data['name'],
            'email' => $data['email'],
            'city' => $data['city'],
            'state' => $data['state']
        ]);

        Session::setFlashMessage('success_message', 'Registration successful.');
        redirect('/');
    }

    public function login($params = []) {
        loadView('Users/login', ['errors' => []]);
    }

    public function authenticate($params = []) {
        Session::start();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email address is required.';
        }
        if ($password === '') {
            $errors[] = 'Password is required.';
        }

        if (empty($errors)) {
            $user = $this->db->Query(
                "SELECT * FROM users WHERE email = :email",
                ['email' => $email]
            )->fetch();

            if (!$user || !password_verify($password, $user->password)) {
                $errors[] = 'Invalid email or password.';
            }
        }

        if (!empty($errors)) {
            loadView('Users/login', ['errors' => $errors]);
            return;
        }

        Session::set('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state
        ]);

        Session::setFlashMessage('success_message', 'Logged in successfully.');
        redirect('/');
    }

    public function logout($params = []) {
        Session::start();
        Session::clearAll();
        redirect('/');
    }
}
?>