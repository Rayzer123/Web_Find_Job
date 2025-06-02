<?php
include '../db_connect.php';
session_start();
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $rs = mysqli_query($conn, $sql);
    if($user = mysqli_fetch_assoc($rs)){
        if(password_verify($pass, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: applicant_dashboard.php');
            exit;
        } else echo "<script>alert('Sai mật khẩu!');</script>";
    } else echo "<script>alert('Email chưa đăng ký!');</script>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Ứng viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    font-family: Arial, sans-serif; /* Áp dụng font chữ */
    display: flex;
    justify-content: center; /* Canh giữa theo chiều ngang */
    align-items: center; /* Canh giữa theo chiều dọc */
    height: 100vh;
    margin: 0;
    background-color: #f8f9fa;
}

.container {
    padding: 40px;
    background-color: white;
    border-radius: 20px; /* Bo góc mềm mại hơn */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Giảm độ đậm của bóng */
    width: 100%;
    max-width: 400px; /* Giới hạn chiều rộng */
    text-align: center;
}

input[type="email"], 
input[type="password"] {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    border: 1px solid #1C1C1C;
    outline: none;
    background-color: #F0F8FF;
    margin-bottom: 12px; /* Tạo khoảng cách giữa các ô nhập */
}

input[type="submit"] {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}



    </style>
</head>
<body>
<div class="container mt-4">
    <h3>Đăng nhập Ứng viên</h3>
    <form method="post">
        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Mật khẩu" required></div>
        <button type="submit" name="login" class="btn btn-primary">Đăng nhập</button>
        <a href="applicant_register.php" class="btn btn-link">Đăng ký mới</a>
    </form>
</div>
</body>
</html>