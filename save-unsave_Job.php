<?php
session_start();
include '../db_connect.php';
if (!isset($_SESSION['user_id'])) {
    echo 'unauthorized';
    exit();
}
$user_id = (int) $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = (int) $_POST['job_id'];
    $action = $_POST['action'];
    if ($action === 'save') {
        // Kiểm tra đã lưu chưa
        $check = $conn->query("SELECT * FROM jobs_saved WHERE user_id = $user_id AND job_id = $job_id");
        if ($check->num_rows === 0) {
            $insert = $conn->query("INSERT INTO jobs_saved (user_id, job_id) VALUES ($user_id, $job_id)");
            echo $insert ? 'saved' : 'error';
        } else {
            echo 'exists';
        }
    } elseif ($action === 'unsave') {
        $delete = $conn->query("DELETE FROM jobs_saved WHERE user_id = $user_id AND job_id = $job_id");
        echo $delete ? 'unsaved' : 'error';
    } else {
        echo 'invalid_action';
    }
}