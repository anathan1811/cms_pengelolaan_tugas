<?php
require_once 'function.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

if (deleteTask($id)) {
    header('Location: dashboard.php');
    exit;
} else {
    echo "Gagal menghapus tugas.";
}