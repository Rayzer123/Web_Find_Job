<?php
include('../db_connect.php');

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu khớp
    if ($pass !== $confirm_password) {
        echo "<script>alert('Mật khẩu không khớp!'); history.back();</script>";
        exit;
    }

    // Mã hóa mật khẩu
    $pass = password_hash($pass, PASSWORD_BCRYPT);

    // Thêm vào CSDL
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Đăng ký thành công!'); location='applicant_login.php';</script>";
    } else {
        // Nếu email bị trùng (UNIQUE constraint)
        if (mysqli_errno($conn) == 1062) {
            echo "<script>alert('Email đã được đăng ký!'); history.back();</script>";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Ứng viên - Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; display: flex; flex-direction: column; min-height: 100vh; } /* */
        .navbar { background: #004b8d; } /* */
        .navbar-brand, .nav-link, .navbar-nav .nav-link.active { color: #fff !important; } /* */
        .navbar .dropdown-menu { min-width: 140px; } /* */
        .register-form { max-width: 500px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .main-content { flex: 1; display: flex; align-items: center; padding-top: 40px; padding-bottom: 40px;}
        .footer { background: #004b8d; color: #fff; text-align: center; padding: 24px 0; } /* */
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg"> <div class="container"> <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" width="60px" height="60px" alt="logoweb"> <a class="navbar-brand fw-bold" href="../index.php">Web Tìm Việc</a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarNav"> <ul class="navbar-nav ms-auto align-items-center"> <li class="nav-item"><a class="nav-link" href="../index.php">Trang chủ</a></li> <li class="nav-item"><a class="nav-link" href="../applicant_jobs.php">Việc làm</a></li> <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">Thành viên</a> <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser"> <li><a class="dropdown-item" href="applicant_login.php">Ứng viên - Đăng nhập</a></li> <li><a class="dropdown-item active" href="applicant_register.php">Ứng viên - Đăng ký</a></li> <li><hr class="dropdown-divider"></li> <li><a class="dropdown-item" href="../employer/employer_login.php">Nhà tuyển dụng - Đăng nhập</a></li> <li><a class="dropdown-item" href="../employer/employer_register.php">Nhà tuyển dụng - Đăng ký</a></li> </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container main-content">
    <div class="register-form">
        <h2 class="text-center mb-4" style="color:#004b8d;">Đăng ký Tài khoản Ứng viên</h2>
        <form action="applicant_register.php" method="POST"> <div class="mb-3">
                <label for="fullName" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="agreeTerms" name="agree_terms" required>
                <label class="form-check-label" for="agreeTerms">Tôi đồng ý với <a href="../terms_of_use.php">Điều khoản sử dụng</a> và <a href="../privacy_policy.php">Chính sách bảo mật</a>.</label>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Đăng ký</button>
            <hr>
            <p class="text-center">Đã có tài khoản? <a href="applicant_login.php">Đăng nhập ngay</a></p>
        </form>
    </div>
</div>

<div class="footer" style="background: #09223b; color: #fff; padding: 48px 0 24px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="footer-title" style="color:#ffb800;font-weight:600;">Về Web Tìm Việc</div>
                <ul class="list-unstyled">
                    <li><a href="../about_us.php" style="color: #fff; text-decoration:none;">Về chúng tôi</a></li>
                    <li><a href="../operational_regulations.php" style="color: #fff; text-decoration:none;">Quy chế hoạt động</a></li>
                    <li><a href="../privacy_policy.php" style="color: #fff; text-decoration:none;">Quy định bảo mật</a></li>
                    <li><a href="../terms_of_use.php" style="color: #fff; text-decoration:none;">Thỏa thuận sử dụng</a></li>
                    <li><a href="../contact_us.php" style="color: #fff; text-decoration:none;">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="footer-title" style="color:#ffb800;font-weight:600;">Dành cho ứng viên</div>
                <ul class="list-unstyled">
                    <li><a href="../applicant_jobs.php" style="color: #fff; text-decoration:none;">Việc làm</a></li>
                    <li><a href="../applicant_jobs.php" style="color: #fff; text-decoration:none;">Tìm việc làm nhanh</a></li>
                    <li><a href="../company_list.php" style="color: #fff; text-decoration:none;">Công ty</a></li>
                    <li><a href="../career_guide.php" style="color: #fff; text-decoration:none;">Cẩm nang việc làm</a></li>
                    <li><a href="../cv_templates.php" style="color: #fff; text-decoration:none;">Mẫu CV Xin Việc</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="footer-title" style="color:#ffb800;font-weight:600;">Việc làm theo khu vực</div>
                <ul class="list-unstyled">
                    <li><a href="../applicant_jobs.php?location=TP.HCM" style="color: #fff; text-decoration:none;">Hồ Chí Minh</a></li>
                    <li><a href="../applicant_jobs.php?location=Hà Nội" style="color: #fff; text-decoration:none;">Hà Nội</a></li>
                    <li><a href="../applicant_jobs.php?location=Đà Nẵng" style="color: #fff; text-decoration:none;">Đà Nẵng</a></li>
                    <li><a href="../applicant_jobs.php?location=Hải Phòng" style="color: #fff; text-decoration:none;">Hải Phòng</a></li>
                    <li><a href="../applicant_jobs.php?location=Cần Thơ" style="color: #fff; text-decoration:none;">Cần Thơ</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Kết nối với chúng tôi</div>
                <div class="mb-2">
                    <img src="../img/logo_team.PNG" height="32" alt="">
                </div>
                <div>
                    <a href="https://www.facebook.com/groups/timvieclamonlinecntt46a"><i class="bi bi-facebook me-1"></i></a>
                    <a href="#"><i class="bi bi-youtube me-1"></i></a>
                    <a href="#"><i class="bi bi-linkedin me-1"></i></a>
                    <a href="https://www.tiktok.com/@timvieclam_46a"><i class="bi bi-tiktok"></i></a>
                </div>
                <div class="mt-2 small">Tải ứng dụng: 
					<div style="display:flex;">
						<img src="../img/vecteezy_badge-google-play-and-app-store-button-download_24170871.PNG" height="28" alt="play">
						<div style = "margin-left: 20px"><img src="../img/vecteezy_badge-google-play-and-app-store-button-download_24170865.PNG" height="28" alt="appstore"></div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3 small">© <?= date("Y") ?> Web Tìm Việc.</div>
    </div>
</div>
