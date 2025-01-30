<?php
require_once 'function.php';
// session_start(); // Mulai session

// Redirect jika sudah login
// if (isset($_SESSION['user_id'])) {
//     header('Location: dashboard.php');
//     exit;
// }

$error = '';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    $user = loginUser($email, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id']; // Simpan user ID ke session
        $_SESSION['user_name'] = $user['name']; // Simpan nama user ke session
        header('Location: dashboard.php'); // Arahkan ke dashboard
        exit;
    } else {
        $error = 'Email atau password salah!';
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Sistem Pengelolaan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            font-size: 2rem;
            height: 4rem;
            width: 4rem;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e9ecef;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        .auth-form {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-check2-square"></i> Task Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="login.php">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Daftar</a> -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Kelola Tugas Anda dengan Mudah</h1>
            <p class="lead mb-4">
                Task Manager membantu Anda mengorganisir dan melacak tugas-tugas dengan efisien.
                Tingkatkan produktivitas tim Anda hari ini!
            </p>
            <a href="login.php" class="btn btn-light btn-lg px-4 me-2">Masuk</a>
            <a href="register.php" class="btn btn-outline-light btn-lg px-4">Daftar</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <h3>Manajemen Tugas</h3>
                        <p>Buat, atur, dan pantau tugas dengan mudah. Tetapkan prioritas dan tenggat waktu.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3>Kolaborasi Tim</h3>
                        <p>Tugaskan pekerjaan ke anggota tim dan pantau progress secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3>Laporan & Analisis</h3>
                        <p>Dapatkan insight dari progress dan kinerja tim Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-white text-dark">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Task Manager. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
