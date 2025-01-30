<?php
session_start(); // Memulai sesi
require_once 'function.php';

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user'])) {
    // header('Location: login.php'); // Redirect ke halaman login jika belum login
    // exit;
}

$user = $_SESSION['user']; // Ambil nama pengguna

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? 'created_at';
$order = $_GET['order'] ?? 'DESC';

$tasks = getAllTasks($search, $status, $category, $sort, $order);
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Pengelolaan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .task-card {
            transition: transform 0.2s;
        }
        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .progress {
            height: 10px;
        }
    </style>
</head>
<body class="bg-light">
  
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="bi bi-check2-square"></i> Task Manager
            </a>
            <div class="d-flex align-items-center ms-auto">
             
                <span class="nav-link">Halo, <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Pengguna'); ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <?php $flash = getFlashMessage(); ?>
        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="h3">Daftar Tugas</h1>
            </div>
            <div class="col-md-4 text-end">
                <a href="create.php" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Tugas
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <form class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari tugas..." value="<?= htmlspecialchars($search) ?>">
                    <select name="status" class="form-select" style="width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                        <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                    <select name="category" class="form-select" style="width: 150px;">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card task-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="badge" style="background-color: <?= $task['category_color'] ?>">
                                <?= htmlspecialchars($task['category_name']) ?>
                            </span>
                            <span class="badge <?= getPriorityBadgeClass($task['priority']) ?>">
                                <?= ucfirst($task['priority']) ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($task['title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($task['description'])) ?></p>
                            
                            <div class="mb-3">
                                <small class="text-muted">Progress:</small>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: <?= $task['completion_percentage'] ?>%"
                                         aria-valuenow="<?= $task['completion_percentage'] ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?= $task['completion_percentage'] ?>%
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> 
                                    Due: <?= formatDueDate($task['due_date']) ?>
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-person"></i>
                                    <?= htmlspecialchars($task['assigned_to'] ?: 'Unassigned') ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100">
                                <a href="update.php?id=<?= $task['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="delete.php?id=<?= $task['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
