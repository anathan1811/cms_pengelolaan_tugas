<?php
require_once 'function.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$task = getTaskById($id);
if (!$task) {
    setFlashMessage('danger', 'Tugas tidak ditemukan.');
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => filter_var($_POST['title'], FILTER_SANITIZE_STRING),
        'description' => filter_var($_POST['description'], FILTER_SANITIZE_STRING),
        'status' => $_POST['status'],
        'priority' => $_POST['priority'],
        'due_date' => $_POST['due_date'],
        'category' => $_POST['category'],
        'assigned_to' => filter_var($_POST['assigned_to'], FILTER_SANITIZE_STRING),
        'completion_percentage' => filter_var($_POST['completion_percentage'], FILTER_SANITIZE_NUMBER_INT)
    ];

    if (updateTask($id, $data)) {
        header('Location: dashboard.php');
        exit;
    }
}

$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-check2-square"></i> Task Manager
            </a>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="h4 mb-0">Edit Tugas</h1>
                    </div>
                    <div class="card-body">
                        <form action="update.php?id=<?= $id ?>" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="<?= htmlspecialchars($task['title']) ?>" required>
                                <div class="invalid-feedback">Judul tugas harus diisi</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="4" required><?= htmlspecialchars($task['description']) ?></textarea>
                                <div class="invalid-feedback">Deskripsi harus diisi</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>" 
                                                    <?= $task['category'] == $category['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Pilih kategori</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-select" id="priority" name="priority" required>
                                        <option value="low" <?= $task['priority'] == 'low' ? 'selected' : '' ?>>Rendah</option>
                                        <option value="medium" <?= $task['priority'] == 'medium' ? 'selected' : '' ?>>Sedang</option>
                                        <option value="high" <?= $task['priority'] == 'high' ? 'selected' : '' ?>>Tinggi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                                        <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="due_date" class="form-label">Tenggat Waktu</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" 
                                           value="<?= $task['due_date'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="assigned_to" class="form-label">Ditugaskan Kepada</label>
                                    <input type="text" class="form-control" id="assigned_to" name="assigned_to" 
                                           value="<?= htmlspecialchars($task['assigned_to']) ?>" 
                                           placeholder="Nama penanggung jawab">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="completion_percentage" class="form-label">Persentase Penyelesaian</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="completion_percentage" 
                                               name="completion_percentage" min="0" max="100" 
                                               value="<?= $task['completion_percentage'] ?>">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="dashboard.php" class="btn btn-light me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Edit</button>
                                <!-- <button type="submit" class="btn btn-primary">Tambah Tugas</button> -->
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Client-side validation for Bootstrap
        (function () {
            'use strict';

            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>