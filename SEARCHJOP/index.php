<?php
// Kết nối database
include 'db_connect.php';

$sql = "SELECT * FROM jobs ORDER BY created_at DESC LIMIT 6";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang chủ - Web Tìm Việc</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f6f8fa; font-family: Arial; }
    .navbar { background: #004b8d; }
    .navbar-brand, .nav-link, .navbar-nav .nav-link.active { color: #fff !important; }

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
    .hero-content { position: relative; z-index: 1; }

    .search-bar {
      background: #fff;
      border-radius: 10px;
      padding: 24px 24px 10px 24px;
      box-shadow: 0 2px 8px #aaa3;
      margin-top: -60px;
      position: relative;
      z-index: 2;
    }

    .job-list { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-top: 30px; }
    .job-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 16px;
      width: 300px;
      transition: transform 0.2s ease-in-out;
    }
    .job-card:hover { transform: scale(1.02); }
    .job-card h3 { font-size: 18px; color: #004b8d; }
    .job-card p { margin-bottom: 6px; font-size: 14px; }
    .job-card a { text-decoration: none; color: #007bff; }

    .footer { background: #09223b; color: #fff; padding: 48px 0 24px 0; margin-top: 60px; }
    .footer-title { color:#ffb800; font-weight:600; margin-bottom:10px; }
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
          <a class="nav-link dropdown-toggle" href="#" id="dropdownUser" data-bs-toggle="dropdown">Thành viên</a>
          <ul class="dropdown-menu dropdown-menu-end">
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
<section class="hero-section text-center">
  <div class="overlay"></div>
  <div class="container hero-content">
    <h1 class="display-5 fw-bold">Tìm việc làm phù hợp với bạn</h1>
    <p class="lead">Cơ hội nghề nghiệp chất lượng cao từ các nhà tuyển dụng uy tín</p>
  </div>
</section>

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

<!-- Job List -->
<div class="container mt-5">
  <h2 class="text-center mb-4 text-primary">Việc làm nổi bật</h2>
  <div class="job-list">
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <div class="job-card">
        <h3><?php echo $row['title']; ?></h3>
        <p><strong>Công ty:</strong> <?php echo $row['company_name']; ?></p>
        <p><strong>Địa điểm:</strong> <?php echo $row['location']; ?></p>
        <p><strong>Lương:</strong> <?php echo $row['salary']; ?></p>
        <a href=".\applicant\applicant_job_detail.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a>
      </div>
    <?php } ?>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="footer-title">Về Web Tìm Việc</div>
        <ul class="list-unstyled">
          <li><a href="#">Về chúng tôi</a></li>
          <li><a href="#">Quy chế hoạt động</a></li>
          <li><a href="#">Quy định bảo mật</a></li>
          <li><a href="#">Thỏa thuận sử dụng</a></li>
          <li><a href="#">Liên hệ</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <div class="footer-title">Dành cho ứng viên</div>
        <ul class="list-unstyled">
          <li><a href="#">Việc làm</a></li>
          <li><a href="#">Tìm việc nhanh</a></li>
          <li><a href="#">Công ty</a></li>
          <li><a href="#">Cẩm nang việc làm</a></li>
          <li><a href="#">Mẫu CV</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <div class="footer-title">Việc làm theo khu vực</div>
        <ul class="list-unstyled">
          <li><a href="#">Hồ Chí Minh</a></li>
          <li><a href="#">Hà Nội</a></li>
          <li><a href="#">Đà Nẵng</a></li>
          <li><a href="#">Cần Thơ</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <div class="footer-title">Kết nối với chúng tôi</div>
        <p><img src="../assets/logoweb.jpg" height="32" alt=""></p>
        <p>
          <a href="#"><i class="bi bi-facebook me-2"></i></a>
          <a href="#"><i class="bi bi-youtube me-2"></i></a>
          <a href="#"><i class="bi bi-linkedin me-2"></i></a>
          <a href="#"><i class="bi bi-tiktok"></i></a>
        </p>
      </div>
    </div>
    <div class="text-center mt-3 small">© <?= date("Y") ?> Web Tìm Việc. Thiết kế bởi Quytop1.</div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
