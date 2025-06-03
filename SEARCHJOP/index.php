

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Web Tìm Việc</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .navbar { background: #004b8d; }
        .navbar-brand, .nav-link, .navbar-nav .nav-link.active { color: #fff !important; }
        .navbar .dropdown-menu { min-width: 140px; }
        .hero-section {
            background: url('https://images.unsplash.com/photo-1515168833906-d2a3b82b2c98?auto=format&fit=crop&w=1350&q=80') no-repeat center;
            background-size: cover;
            padding: 80px 0 90px 0;
            color: #fff;
            position: relative;
        }
        .hero-section .overlay {
            position: absolute;
            top:0; left:0; right:0; bottom:0;
            background: rgba(0,75,141,0.55);
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .search-bar {
            background: #fff;
            border-radius: 10px;
            padding: 24px 24px 10px 24px;
            box-shadow: 0 2px 8px #aaa3;
            margin-top: -60px;
            position: relative;
            z-index: 2;
        }
        .job-list-title { color: #004b8d; }
        .footer { background: #004b8d; color: #fff; text-align: center; padding: 24px 0; margin-top:40px;}
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" width="60px" height="60px" alt="logoweb">
    <a class="navbar-brand fw-bold" href="index.php">Web Tìm Việc</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link active" href="index.php">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="applicant_jobs.php">Việc làm</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">Thành viên</a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="applicant/applicant_login.php">Ứng viên - Đăng nhập</a></li>
            <li><a class="dropdown-item" href="applicant/applicant_register.php">Ứng viên - Đăng ký</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="employer/employer_login.php">Nhà tuyển dụng - Đăng nhập</a></li>
            <li><a class="dropdown-item" href="employer/employer_register.php">Nhà tuyển dụng - Đăng ký</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="hero-section position-relative mb-4">
    <div class="overlay"></div>
    <div class="container hero-content text-center">
        <h1 class="display-5 fw-bold mb-3">Tìm việc làm mơ ước của bạn</h1>
        <p class="lead mb-4">Hàng ngàn cơ hội việc làm từ các công ty hàng đầu Việt Nam</p>
        <a href="./applicant/applicant_jobs.php" class="btn btn-primary btn-lg me-2">Tìm việc ngay</a>
        <a href="./employer/employer_register.php" class="btn btn-outline-light btn-lg ms-2">Đăng tin tuyển dụng</a>
    </div>
</div>

<!-- Search Bar -->
<div class="container search-bar shadow">
    <form class="row g-3 align-items-center" action="./applicant/applicant_jobs.php" method="get">
        <div class="col-md-5">
            <input type="text" class="form-control" name="search" placeholder="Nhập từ khóa (VD: Kế toán, IT...)">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="location" placeholder="Địa điểm (VD: TP.HCM, Hà Nội...)">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100" type="submit">Tìm việc ngay</button>
        </div>
    </form>
</div>

<!-- Danh sách việc làm nổi bật -->
<div class="container mt-5">
    <h2 class="mb-4 job-list-title">Việc làm nổi bật</h2>
    <div class="row">
        <!-- Demo dữ liệu tĩnh; thay vòng lặp PHP nếu có DB -->
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Nhân viên hành chính nhân sự</h5>
              <p class="card-text">Công ty TNHH ABC • Hà Nội</p>
              <a href="applicant/applicant_job_detail.php?id=1" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Kỹ sư phần mềm</h5>
              <p class="card-text">Công ty Phần mềm XYZ • TP.HCM</p>
              <a href="applicant/applicant_job_detail.php?id=2" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Nhân viên marketing</h5>
              <p class="card-text">Công ty Marketing 123 • Đà Nẵng</p>
              <a href="applicant/applicant_job_detail.php?id=3" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
        <!-- Kết thúc mẫu -->
    </div>
</div>

<!-- Footer -->
<div class="footer mt-5" style="background: #09223b; color: #fff; padding: 48px 0 24px 0;">
  <div class="container">
    <div class="row">
      <div class="col-md-3"><div class="footer-title" style="color:#ffb800;font-weight:600;">Về Web Tìm Việc</div>
        <ul class="list-unstyled">
          <li><a href="#">Về chúng tôi</a></li>
          <li><a href="#">Quy chế hoạt động</a></li>
          <li><a href="#">Quy định bảo mật</a></li>
          <li><a href="#">Thỏa thuận sử dụng</a></li>
          <li><a href="#">Liên hệ</a></li>
        </ul>
      </div>
      <div class="col-md-3"><div class="footer-title" style="color:#ffb800;font-weight:600;">Dành cho ứng viên</div>
        <ul class="list-unstyled">
          <li><a href="#">Việc làm</a></li>
          <li><a href="#">Tìm việc làm nhanh</a></li>
          <li><a href="#">Công ty</a></li>
          <li><a href="#">Cẩm nang việc làm</a></li>
          <li><a href="#">Mẫu CV Xin Việc</a></li>
        </ul>
      </div>
      <div class="col-md-3"><div class="footer-title" style="color:#ffb800;font-weight:600;">Việc làm theo khu vực</div>
        <ul class="list-unstyled">
          <li><a href="#">Hồ Chí Minh</a></li>
          <li><a href="#">Hà Nội</a></li>
          <li><a href="#">Đà Nẵng</a></li>
          <li><a href="#">Hải Phòng</a></li>
          <li><a href="#">Cần Thơ</a></li>
        </ul>
      </div>
      <div class="col-md-3"><div class="footer-title" style="color:#ffb800;font-weight:600;">Kết nối với chúng tôi</div>
        <div class="mb-2"><img src="../assets/logoweb.jpg" height="32" alt=""></div>
        <div>
          <a href="#"><i class="bi bi-facebook me-1"></i></a>
          <a href="#"><i class="bi bi-youtube me-1"></i></a>
          <a href="#"><i class="bi bi-linkedin me-1"></i></a>
          <a href="#"><i class="bi bi-tiktok"></i></a>
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