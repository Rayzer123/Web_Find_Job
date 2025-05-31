<?php
include('../db_connect.php');
session_start();
if(!isset($_SESSION['employer_id'])) header('Location: employer_login.php');
$employer_id = $_SESSION['employer_id'];
if(isset($_POST['post'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $sql = "INSERT INTO jobs (title, description, employer_id, created_at) VALUES ('$title', '$desc', '$employer_id', NOW())";
    mysqli_query($conn, $sql);
    echo "<div class='alert alert-success'>Đăng tin thành công!</div>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng tin tuyển dụng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Đăng tin tuyển dụng mới</h3>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Vị trí tuyển dụng</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả công việc</label>
            <textarea class="form-control" name="description" rows="6" required></textarea>
        </div>
        <button type="submit" name="post" class="btn btn-primary">Đăng tin</button>
    </form>
</div>
</body>
</html>