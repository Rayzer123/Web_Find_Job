<?php
// Thông báo việc làm
session_start();
include '../db_connect.php';
$applicant_id = $_SESSION['applicant_id'] ?? 0;
// $notifications = ... // Truy vấn danh sách thông báo việc làm đã đăng ký
$notifications = []; // Demo, thay bằng query của bạn
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo việc làm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body { background: #f6f8fa;}
        .noti-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .empty-box {border: 2px dashed #bcd8f8; border-radius: 16px; padding: 32px 0; text-align: center; background: #fafdff;}
        .empty-box .icon {font-size: 2.8rem; color: #85b8e6; margin-bottom: 12px;}
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>
<div class="container my-4">
    <div class="noti-box">
        <h5 class="mb-4 text-primary fw-bold">Thông báo việc làm của tôi (<?= count($notifications) ?>)</h5>
        <?php if(empty($notifications)): ?>
            <div class="empty-box">
                <div class="icon">🔔</div>
                Chưa có thông báo việc làm nào được thiết lập<br>
                <a href="#" class="btn btn-outline-primary mt-2">+ Tạo thông báo việc làm mới</a>
            </div>
        <?php else: ?>
            <!-- Hiện danh sách thông báo -->
        <?php endif; ?>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
</body>
</html>