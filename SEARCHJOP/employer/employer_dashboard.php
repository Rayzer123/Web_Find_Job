<?php
session_start();
if(!isset($_SESSION['employer_id'])) header('Location: employer_login.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng điều khiển Nhà tuyển dụng | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .sidebar {
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #e6e9ef;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: #e3f1ff;
            color: #004b8d !important;
            font-weight: 600;
        }
        .sidebar .nav-link { color: #333; }
        .sidebar .nav-link i { width: 20px; }
        .sidebar-bottom {
            position: absolute; bottom: 0; width: 220px; padding: 12px; font-size: 14px; color: #888;
        }
        .main-content { background: #f6f8fa; min-height: 100vh; }
        .dashboard-header { color: #004b8d; font-size: 22px; }
        .dashboard-card {
            background: #fff;
            border-radius: 8px;
            padding: 28px 24px 20px 24px;
            box-shadow: 0 2px 8px #aaa3;
            margin-bottom: 32px;
        }
        .dashboard-actions .btn { min-width: 170px; margin-bottom: 12px;}
        .welcome-bg {
            background: linear-gradient(90deg,#e3f1ff 0,#f5fdff 100%);
            border-radius: 12px; 
            padding: 30px 40px 20px 40px;
            margin-bottom: 32px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-2 sidebar px-0 d-flex flex-column position-relative">
            <div class="pt-4 ps-3 mb-2">
               <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                    <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" class="me-2" alt="Logo" width="60" height="60"> Web Tìm Việc
                </a>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" href="employer_dashboard.php"><i class="bi bi-person"></i> My Web</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Công Việc</div>
                <a class="nav-link" href="employer_jobs.php"><i class="bi bi-briefcase"></i> Công việc của tôi</a>
                <a class="nav-link" href="employer_post_job.php"><i class="bi bi-plus-square"></i> Đăng Tuyển dụng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Ứng viên của tôi</div>
                <a class="nav-link" href="employer_search.php"><i class="bi bi-search"></i> Tìm kiếm tài năng</a>
                <a class="nav-link" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                <a class="nav-link" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Blog</div>
                <a class="nav-link" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển dụng</a>
                <a class="nav-link" href="employer_interview.php"><i class="bi bi-chat"></i> Phỏng vấn nhiều vòng...</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small"> </div>
                <a class="nav-link" href="employer_help.php"><i class="bi bi-question-circle"></i> Hỗ trợ</a>
                <a class="nav-link" href="employer_organization.php"><i class="bi bi-people"></i> Tổ chức</a>
                <a class="nav-link" href="employer_settings.php"><i class="bi bi-gear"></i> Cài đặt</a>
            </nav>
            <div class="sidebar-bottom">
                <div><b><?= htmlspecialchars($_SESSION['employer_name']) ?></b></div>
                <div style="font-size:13px;"><?= htmlspecialchars($_SESSION['employer_email'] ?? '') ?></div>
            </div>
        </div>
        <!-- Main -->
        <div class="col-10 main-content px-5 py-4">
            <div class="welcome-bg">
                <h2 class="dashboard-header mb-2">Chào mừng, <?= htmlspecialchars($_SESSION['employer_name']) ?>!</h2>
                <p class="mb-0">Quản lý tuyển dụng dễ dàng trên Web Tìm Việc.<br>
                Đăng tin tuyển dụng, xem ứng viên nộp hồ sơ và quản lý các vị trí tuyển dụng của bạn tại đây.</p>
            </div>
            <div class="row dashboard-actions mb-4">
                <div class="col-md-4">
                    <div class="dashboard-card text-center">
                        <h5>Đăng tin tuyển dụng</h5>
                        <p>Đăng tin miễn phí, tiếp cận hàng ngàn ứng viên tiềm năng.</p>
                        <a href="employer_post_job.php" class="btn btn-primary">Đăng tin mới</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-card text-center">
                        <h5>Xem ứng viên đã nộp</h5>
                        <p>Quản lý danh sách ứng viên ứng tuyển vào các vị trí của bạn.</p>
                        <a href="employer_applicants.php" class="btn btn-success">Xem ứng viên</a> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-card text-center">
                        <h5>Đăng xuất</h5>
                        <p>Thoát khỏi tài khoản nhà tuyển dụng.</p>
                        <a href="employer_logout.php" class="btn btn-danger">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>