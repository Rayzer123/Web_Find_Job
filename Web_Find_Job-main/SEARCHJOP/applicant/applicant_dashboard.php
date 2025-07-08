<?php
session_start();
// (Nếu cần kiểm tra đăng nhập thì thêm dòng kiểm tra session tại đây)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Ứng Viên | Web Tìm Việc</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .navbar { background: #fff; box-shadow: 0 2px 8px #e9ecef; }
        .navbar-brand img { height: 38px; }
        .nav-link, .navbar-nav .nav-link.active { color: #004b8d !important; }
        .dropdown-menu { min-width: 240px; }
        .main-search { background: #eaf4fd; padding: 36px 0 18px 0; }
        .main-search .form-control { border-radius: 8px; }
        .section-title { color: #004b8d; font-weight: 700; margin-bottom: 18px; }
        .job-card { border-radius: 10px; box-shadow: 0 2px 8px #e9ecef; transition: 0.2s; }
        .job-card:hover { box-shadow: 0 6px 24px #aacbee66; }
        .category-card { border-radius: 14px; background: #fff; box-shadow: 0 2px 8px #e9ecef; padding: 22px 0; transition: 0.2s; cursor:pointer;}
        .category-card:hover { background: #e3f1ff; }
        .footer { background: #09223b; color: #fff; padding: 48px 0 24px 0;}
        .footer a { color: #fff; text-decoration: underline;}
        .footer .footer-col { margin-bottom: 26px;}
        .footer .footer-title { font-weight: 600; color: #ffb800;}
        .quick-actions .btn { border-radius: 20px; min-width: 130px; }
        .avatar-circle { width:40px; height:40px; border-radius:50%; background:#004b8d; color:#fff; font-weight:700; font-size:22px; display:flex; align-items:center; justify-content:center;}
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
            <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" class="me-2" alt="Logo"> Web Tìm Việc
        </a>
        <form class="d-none d-lg-flex ms-3 flex-grow-1" style="max-width: 450px;">
            <input type="text" class="form-control" placeholder="Nhập vị trí, từ khóa, công ty...">
            <button class="btn btn-primary ms-2" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar-circle me-2"><?= strtoupper(substr($_SESSION['user_name'] ?? 'UV',0,1)) ?></span>
                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'Ứng viên') ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="applicant_profile.php"><i class="bi bi-person-vcard me-2"></i> Hồ sơ xin việc</a></li>
                    <li><a class="dropdown-item" href="applicant_saved.php"><i class="bi bi-heart me-2"></i> Việc đã lưu</a></li>
                    <li><a class="dropdown-item" href="applicant_applied.php"><i class="bi bi-send me-2"></i> Việc đã ứng tuyển</a></li>
                    <li><a class="dropdown-item" href="applicant_notifications.php"><i class="bi bi-bell me-2"></i> Thông báo việc làm</a></li>
                    <li><a class="dropdown-item" href="applicant_account.php"><i class="bi bi-person me-2"></i> Tài khoản</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="applicant_logout.php"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- Main Search -->
<div class="main-search">
    <div class="container">
        <form class="row g-2" method="get" action="applicant_jobs.php">
            <div class="col-12 col-md-5">
                <input type="text" class="form-control" name="search" placeholder="Nhập từ khóa (VD: Kế toán, IT...)">
            </div>
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" name="location" placeholder="Địa điểm (VD: TP.HCM, Hà Nội...)">
            </div>
            <div class="col-12 col-md-3 d-grid">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search me-1"></i> Tìm việc ngay</button>
            </div>
        </form>
        <div class="quick-actions mt-3 text-center">
            <a href="applicant_saved.php" class="btn btn-outline-primary me-2"><i class="bi bi-heart"></i> Việc đã lưu</a>
            <a href="applicant_applied.php" class="btn btn-outline-success me-2"><i class="bi bi-send"></i> Đã ứng tuyển</a>
            <a href="applicant_profile.php" class="btn btn-outline-info"><i class="bi bi-person-vcard"></i> Hồ sơ cá nhân</a>
        </div>
    </div>
</div>
<!-- Jobs Section -->
<div class="container mt-4">
    <div class="section-title">Việc làm hấp dẫn</div>
    <div class="row g-3">
        <!-- Mẫu việc làm, có thể lặp bằng PHP khi có DB -->
        <div class="col-md-4">
            <div class="job-card p-3">
                <div class="d-flex justify-content-between">
                    <span class="badge bg-danger">HOT</span>
                    <span class="text-muted small"><i class="bi bi-clock"></i> 16 giờ trước</span>
                </div>
                <h5 class="mb-1 mt-1">Trưởng phòng Hành chính nhân sự</h5>
                <div class="text-muted mb-2 small">Công ty CP Sản Xuất Vật Liệu Xây Dựng<br><i class="bi bi-geo-alt"></i> Hồ Chí Minh</div>
                <div class="mb-2"><span class="text-primary fw-bold">20 triệu - 35 triệu</span></div>
                <a href="applicant_job_detail.php?id=1" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="job-card p-3">
                <div class="d-flex justify-content-between">
                    <span class="badge bg-danger">HOT</span>
                    <span class="text-muted small"><i class="bi bi-clock"></i> 3 ngày trước</span>
                </div>
                <h5 class="mb-1 mt-1">Kỹ sư HVAC (Điều hoà - Thông gió)</h5>
                <div class="text-muted mb-2 small">Công ty TNHH HA Consultants<br><i class="bi bi-geo-alt"></i> Nhật Bản</div>
                <div class="mb-2"><span class="text-primary fw-bold">Trên 44 triệu</span></div>
                <a href="applicant_job_detail.php?id=2" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="job-card p-3">
                <div class="d-flex justify-content-between">
                    <span class="badge bg-danger">HOT</span>
                    <span class="text-muted small"><i class="bi bi-clock"></i> 2 ngày trước</span>
                </div>
                <h5 class="mb-1 mt-1">Nhân viên quản lý dự án</h5>
                <div class="text-muted mb-2 small">Fil Inc.<br><i class="bi bi-geo-alt"></i> Hồ Chí Minh</div>
                <div class="mb-2"><span class="text-success fw-bold">Thương lượng</span></div>
                <a href="applicant_job_detail.php?id=3" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
            </div>
        </div>
        <!-- ...có thể thêm nhiều job-card khác -->
    </div>
</div>
<!-- Jobs by Category -->
<div class="container mt-5">
    <div class="section-title">Việc làm theo ngành nghề</div>
    <div class="row g-3">
        <div class="col-6 col-md-2">
            <div class="category-card text-center">
                <i class="bi bi-calculator display-6 mb-2"></i>
                <div>Kế toán / Kiểm toán</div>
                <div class="text-muted small">1689 việc làm</div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="category-card text-center">
                <i class="bi bi-broadcast display-6 mb-2"></i>
                <div>Quảng cáo / Khuyến mãi</div>
                <div class="text-muted small">1177 việc làm</div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="category-card text-center">
                <i class="bi bi-flower2 display-6 mb-2"></i>
                <div>Nông nghiệp</div>
                <div class="text-muted small">1553 việc làm</div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="category-card text-center">
                <i class="bi bi-palette2 display-6 mb-2"></i>
                <div>Nghệ thuật / Giải trí</div>
                <div class="text-muted small">728 việc làm</div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="category-card text-center">
                <i class="bi bi-bank display-6 mb-2"></i>
                <div>Ngân hàng</div>
                <div class="text-muted small">881 việc làm</div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="category-card text-center">
                <i class="bi bi-gear-fill display-6 mb-2"></i>
                <div>Thư ký / Hành chính</div>
                <div class="text-muted small">1470 việc làm</div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<div class="footer mt-5">
    <div class="container">
        <div class="row footer-col">
            <div class="col-md-3 footer-col">
                <div class="footer-title">Về Web Tìm Việc</div>
                <ul class="list-unstyled">
                    <li><a href="#">Về chúng tôi</a></li>
                    <li><a href="#">Quy chế hoạt động</a></li>
                    <li><a href="#">Quy định bảo mật</a></li>
                    <li><a href="#">Thỏa thuận sử dụng</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Dành cho ứng viên</div>
                <ul class="list-unstyled">
                    <li><a href="#">Việc làm</a></li>
                    <li><a href="#">Tìm việc làm nhanh</a></li>
                    <li><a href="#">Công ty</a></li>
                    <li><a href="#">Cẩm nang việc làm</a></li>
                    <li><a href="#">Mẫu CV Xin Việc</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Việc làm theo khu vực</div>
                <ul class="list-unstyled">
                    <li><a href="#">Hồ Chí Minh</a></li>
                    <li><a href="#">Hà Nội</a></li>
                    <li><a href="#">Đà Nẵng</a></li>
                    <li><a href="#">Hải Phòng</a></li>
                    <li><a href="#">Cần Thơ</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Kết nối với chúng tôi</div>
                <div class="mb-2">
                    <img src="../assets/logoweb.jpg" height="32" alt="">
                </div>
                <div>
                    <a href="#"><i class="bi bi-facebook me-1"></i></a>
                    <a href="#"><i class="bi bi-youtube me-1"></i></a>
                    <a href="#"><i class="bi bi-linkedin me-1"></i></a>
                    <a href="#"><i class="bi bi-tiktok"></i></a>
                </div>
                <div class="mt-2 small">Tải ứng dụng: 
                    <img src="https://careerlink.vn/static/img/app-googleplay.png" height="28" alt="play">
                    <img src="https://careerlink.vn/static/img/app-appstore.png" height="28" alt="appstore">
                </div>
            </div>
        </div>
        <div class="text-center mt-3 small">© <?= date("Y") ?> Web Tìm Việc. Thiết kế bởi Quytop1.</div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>