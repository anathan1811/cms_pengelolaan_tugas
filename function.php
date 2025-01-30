<?php
require_once 'config/database.php';
// session_start();

function getAllTasks($search = '', $status = '', $category = '', $sort = 'created_at', $order = 'DESC') {
    global $pdo;
    
    $query = 'SELECT t.*, c.name as category_name, c.color as category_color 
              FROM tasks t 
              LEFT JOIN categories c ON t.category = c.id 
              WHERE 1=1';
    $params = [];
    
    if ($search) {
        $query .= ' AND (t.title LIKE ? OR t.description LIKE ?)';
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    if ($status) {
        $query .= ' AND t.status = ?';
        $params[] = $status;
    }
    
    if ($category) {
        $query .= ' AND t.category = ?';
        $params[] = $category;
    }
    
    $query .= " ORDER BY t.$sort $order";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getAllCategories() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
    return $stmt->fetchAll();
}

function createTask($data) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO tasks (title, description, status, priority, due_date, category, assigned_to, completion_percentage) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    
    $result = $stmt->execute([
        $data['title'],
        $data['description'],
        $data['status'],
        $data['priority'],
        $data['due_date'] ?: null,
        $data['category'],
        $data['assigned_to'],
        $data['completion_percentage']
    ]);
    
    if ($result) {
        setFlashMessage('success', 'Tugas berhasil ditambahkan!');
        return true;
    }
    return false;
}

function updateTask($id, $data) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE tasks SET 
                          title = ?, 
                          description = ?, 
                          status = ?, 
                          priority = ?,
                          due_date = ?,
                          category = ?,
                          assigned_to = ?,
                          completion_percentage = ?
                          WHERE id = ?');
    
    $result = $stmt->execute([
        $data['title'],
        $data['description'],
        $data['status'],
        $data['priority'],
        $data['due_date'] ?: null,
        $data['category'],
        $data['assigned_to'],
        $data['completion_percentage'],
        $id
    ]);
    
    if ($result) {
        setFlashMessage('success', 'Tugas berhasil diperbarui!');
        return true;
    }
    return false;
}

function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function formatDueDate($date) {
    if (!$date) return '-';
    $dueDate = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($dueDate);
    
    if ($dueDate < $now) {
        return '<span class="text-danger">Terlambat ' . $interval->days . ' hari</span>';
    } elseif ($interval->days == 0) {
        return '<span class="text-warning">Hari ini</span>';
    } else {
        return '<span class="text-success">' . $interval->days . ' hari lagi</span>';
    }
}

function getPriorityBadgeClass($priority) {
    $classes = [
        'low' => 'bg-success',
        'medium' => 'bg-warning',
        'high' => 'bg-danger'
    ];
    return $classes[$priority] ?? 'bg-secondary';
}

function getTaskById($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT t.*, c.name as category_name, c.color as category_color 
                          FROM tasks t 
                          LEFT JOIN categories c ON t.category = c.id 
                          WHERE t.id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function deleteTask($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    
    $result = $stmt->execute([$id]);
    
    if ($result) {
        setFlashMessage('success', 'Tugas berhasil dihapus!');
        return true;
    } else {
        setFlashMessage('danger', 'Gagal menghapus tugas.');
        return false;
    }
}

// Tambahkan fungsi-fungsi ini ke dalam file function.php

function loginUser($email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare('SELECT id, password FROM user WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function registerUser($name, $email, $password) {
    global $pdo;
    
    // Check if email already exists
    $stmt = $pdo->prepare('SELECT id FROM user WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return false;
    }
    
    // Hash password and insert new user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO user (name, email, password) VALUES (?, ?, ?)');
    return $stmt->execute([$name, $email, $hashedPassword]);
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: landing.php');
        exit;
    }
}