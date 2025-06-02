<?php
session_start();
include '../db_connect.php';
$applicant_id = $_SESSION['user_id'] ?? 0;
$query = $conn->prepare("SELECT name FROM users WHERE id = ?");
$query->bind_param("i", $applicant_id);
$query->execute();
$result = $query->get_result();
$account = $result->fetch_assoc();
if(isset($_POST['create'])){
    $u_id = $applicant_id;
    $user = $account['name'];
    $profession = $_POST['profession'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];
    $language = $_POST['language'];

    $sql = "INSERT INTO resumes (user_id, users, profession, experience, education, language) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $u_id, $user, $profession, $experience, $education, $language);

    $stmt->execute();
    

    $stmt->close();
    header("Location: applicant_profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Ứng viên</title>
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
input[type="text"],
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
    <h3>Hồ sơ cơ bản</h3>
    <form method="post">
        <div class="mb-3"><input type="text" name="profession" class="form-control" placeholder="Ngành nghề" required></div>
        <div class="mb-3"><input type="text" name="experience" class="form-control" placeholder="Kinh nghiệm làm việc" required></div>
        <div class="mb-3"><input type="text" name="education" class="form-control" placeholder="Trình độ học vấn" required></div>
        <div class="mb-3"><input type="text" name="language" class="form-control" placeholder="Trình độ ngoại ngữ" required></div>
        <button type="submit" name="create" class="btn btn-primary">Tạo hồ sơ</button>
    </form>
</div>
</body>
</html>