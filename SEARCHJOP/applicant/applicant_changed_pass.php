<?php
session_start();
include '../db_connect.php';
$applicant_id = $_SESSION['user_id'] ?? 0;
$query = $conn->prepare("SELECT password FROM users WHERE id = ?");
$query->bind_param("i", $applicant_id);
$query->execute();
$result = $query->get_result();
$account = $result->fetch_assoc();
if (isset($_POST['changed_pass'])) {
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $newpassconfirm = $_POST['newpassconfirm'];

    // Kiểm tra mật khẩu mới có khớp
    if ($newpass !== $newpassconfirm) {
        echo "<script>alert('Mật khẩu mới không khớp!');</script>";
    }
    // Kiểm tra mật khẩu cũ đúng không
    elseif (!password_verify($oldpass, $account['password'])) {
        echo "<script>alert('Mật khẩu cũ không đúng!');</script>";
    }
    else {
        // Update mật khẩu mới
        $hashed_newpass = password_hash($newpass, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashed_newpass, $applicant_id);
        if ($update->execute()) {
            echo "<script>alert('Đổi mật khẩu thành công!');</script>";

            // Tự load lại trang sau khi đổi xong
            header("Location: applicant_account.php");
            exit;
        } else {
            echo "<script>alert('Đổi mật khẩu thất bại!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
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
input[type="oldpass"],
input[type="newpass"], 
input[type="newpassconfirm"] {
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

.btn-google {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    margin-top: 10px;
    padding: 12px;
    border: none;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-google img {
    width: 20px;
}

.btn-google:hover {
    background-color: #f1f1f1;
}

    </style>
</head>
<body>
<div class="container mt-4">
    <h3>Đổi mật khẩu</h3>
    <form method="post">
        <div class="mb-3"><input type="password" name="oldpass" class="form-control" placeholder="Mật khẩu cũ" required></div>
        <div class="mb-3"><input type="password" name="newpass" class="form-control" placeholder="Mật khẩu mới" required></div>
        <div class="mb-3"><input type="password" name="newpassconfirm" class="form-control" placeholder="Xác nhận mật khẩu mới" required></div>
        <button type="submit" name="changed_pass" class="btn btn-primary">Đổi mật khẩu</button>
    </form>
</div>
</body>
</html>