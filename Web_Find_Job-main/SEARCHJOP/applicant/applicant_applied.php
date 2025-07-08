<?php
// Việc đã ứng tuyển
session_start();
include '../db_connect.php';
$applicant_id = $_SESSION['applicant_id'] ?? 0;
// $applied_jobs = ... // Truy vấn jobs đã ứng tuyển
$applied_jobs = []; // Demo, thay bằng query jobs đã ứng tuyển
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Việc đã ứng tuyển</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body { background: #f6f8fa;}
        .applied-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .empty-box {border: 2px dashed #bcd8f8; border-radius: 16px; padding: 32px 0; text-align: center; background: #fafdff;}
        .empty-box .icon {font-size: 2.8rem; color: #85b8e6; margin-bottom: 12px;}
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>
<div class="container my-4">
    <div class="applied-box">
        <h5 class="mb-4 text-primary fw-bold">Việc đã ứng tuyển (<?= count($applied_jobs) ?>)</h5>
        <?php if(empty($applied_jobs)): ?>
            <div class="empty-box">
                <div class="icon">🛫</div>
                Bạn chưa nộp đơn cho việc làm nào...<br>
                <a href="applicant_jobs.php" class="btn btn-primary mt-2">Đến trang tìm việc</a>
            </div>
        <?php else: ?>
            <!-- Hiện danh sách job đã ứng tuyển -->
        <?php endif; ?>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
</body>
</html>