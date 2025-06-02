<?php
// Công việc đã lưu
session_start();
include '../db_connect.php';
$applicant_id = $_SESSION['applicant_id'] ?? 0;
// $saved_jobs = ... // Truy vấn danh sách job đã lưu của ứng viên
$saved_jobs = []; // Demo, thay bằng query lấy job đã lưu
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Công việc đã lưu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body { background: #f6f8fa;}
        .saved-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .empty-box {border: 2px dashed #bcd8f8; border-radius: 16px; padding: 32px 0; text-align: center; background: #fafdff;}
        .empty-box .icon {font-size: 2.8rem; color: #85b8e6; margin-bottom: 12px;}
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>
<div class="container my-4">
    <div class="saved-box">
        <h5 class="mb-4 text-primary fw-bold">Công việc đã lưu (<?= count($saved_jobs) ?>)</h5>
        <?php if(empty($saved_jobs)): ?>
            <div class="empty-box">
                <div class="icon">🤍</div>
                Lưu lại việc làm bạn quan tâm để xem lại dễ dàng!<br>
                <a href="applicant_jobs.php" class="btn btn-primary mt-2">Đến trang tìm việc</a>
            </div>
        <?php else: ?>
            <!-- Hiện danh sách job đã lưu -->
        <?php endif; ?>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
</body>
</html>