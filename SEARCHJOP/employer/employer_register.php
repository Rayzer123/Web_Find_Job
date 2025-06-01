<?php
include('../db_connect.php');
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO employers (company_name, email, password) VALUES ('$name', '$email', '$pass')";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Đăng ký thành công!'); location='employer_login.php';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Nhà tuyển dụng</title>
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
    <h3>Đăng ký tài khoản Nhà tuyển dụng</h3>
    <form method="post">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Tên công ty" required></div>
        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Mật khẩu" required></div>
        <button type="submit" name="register" class="btn btn-primary">Đăng ký</button>
        <a href="employer_login.php" class="btn btn-link">Đã có tài khoản?</a>
    </form>
</div>
</body>
</html>