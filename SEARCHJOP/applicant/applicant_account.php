<?php
// Trang tài khoản/thông tin cá nhân
session_start();
include '../db_connect.php';
$applicant_id = $_SESSION['applicant_id'] ?? 0;
// Lấy thông tin tài khoản từ DB
$account = [
    'full_name' => 'Quy Nguyenxuan',
    'email' => 'nguyenxuanquy2005thd@gmail.com',
    'gender' => '',
    'dob' => '',
    'marital_status' => '',
    'phone' => '',
    'address' => ', Viet Nam',
    'created_at' => '31/5/2025'
];
// Demo, thay bằng query thực tế lấy thông tin tài khoản từ bảng applicant
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tài khoản ứng viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body { background: #f6f8fa;}
        .account-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .section-title {font-weight: 700; font-size: 1.5rem; color: #003366;}
        .avatar {width:80px;height:80px;border-radius:50%;background:#e3e5e7;display:flex;align-items:center;justify-content:center;font-size:2.2rem;}
        .info-label {color:#888;}
        .edit-link {color:#1a7cdf;text-decoration:none;}
        .edit-link:hover {text-decoration:underline;}
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>
<div class="container my-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="account-box">
                <h6 class="fw-bold mb-3">Tài khoản</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a class="nav-link active" href="#">Tài khoản</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="#">Đổi mật khẩu</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="#">Thông báo email</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="account-box">
                <div class="section-title mb-3">Tài khoản</div>
                <p>Hãy cập nhật thông tin mới nhất.<br>
                Thông tin cá nhân dưới đây sẽ tự động điền khi bạn tạo hồ sơ mới.</p>
                <div class="row align-items-center mb-4">
                    <div class="col-md-2">
                        <div class="avatar text-center"><i class="bi bi-person"></i></div>
                    </div>
                    <div class="col-md-10">
                        <a href="#" class="edit-link">Chỉnh sửa</a>
                        <div class="small text-muted">(JPEG/PNG/GIF, ≤ 1MB)</div>
                    </div>
                </div>
                <table class="table">
                    <tr>
                        <td class="info-label">Họ và tên *</td>
                        <td class="fw-bold"><?= htmlspecialchars($account['full_name']) ?></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                    <tr>
                        <td class="info-label">Địa chỉ email *</td>
                        <td><?= htmlspecialchars($account['email']) ?> <span class="text-success">✔</span></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                    <tr>
                        <td class="info-label">Giới tính</td>
                        <td><?= $account['gender'] ?: '...' ?></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                    <tr>
                        <td class="info-label">Ngày sinh</td>
                        <td><?= $account['dob'] ?: 'Nhập ngày sinh của bạn' ?></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                    <tr>
                        <td class="info-label">Tình trạng hôn nhân</td>
                        <td><?= $account['marital_status'] ?: '...' ?></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                    <tr>
                        <td class="info-label">Số điện thoại</td>
                        <td><?= $account['phone'] ?: 'Thêm số điện thoại của bạn' ?></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                    <tr>
                        <td class="info-label">Địa chỉ</td>
                        <td><?= $account['address'] ?></td>
                        <td><a href="#" class="edit-link">Chỉnh sửa</a></td>
                    </tr>
                </table>
                <div class="text-end text-muted small">Ngày đăng ký: <?= $account['created_at'] ?></div>
                <div class="mt-2"><a href="#" class="text-danger">➖ Xóa tài khoản</a></div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
</body>
</html>