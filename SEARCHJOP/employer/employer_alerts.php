<?php
session_start();
if (!isset($_SESSION['employer_id'])) header('Location: employer_login.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Thông báo Tuyển dụng | Web Tìm Việc</title>
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
        .dashboard-header { color: #004b8d; font-size: 22px; margin-bottom: 24px; }
        .form-label { font-weight: 500; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-2 sidebar px-0 d-flex flex-column position-relative">
            <div class="pt-4 ps-3 mb-2">
                <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" height="60" width="60" alt="Logo">
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="employer_dashboard.php"><i class="bi bi-person"></i> My Web</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Công Việc</div>
                <a class="nav-link" href="employer_jobs.php"><i class="bi bi-briefcase"></i> Công việc của tôi</a>
                <a class="nav-link" href="employer_post_job.php"><i class="bi bi-plus-square"></i> Đăng Tuyển dụng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Ứng viên của tôi</div>
                <a class="nav-link" href="employer_search.php"><i class="bi bi-search"></i> Tìm kiếm tài năng</a>
                <a class="nav-link" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                <a class="nav-link active" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Blog</div>
                <a class="nav-link" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển dụng</a>
                <a class="nav-link" href="#"><i class="bi bi-chat"></i> Phỏng vấn nhiều vòng...</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small"> </div>
                <a class="nav-link" href="#"><i class="bi bi-question-circle"></i> Hỗ trợ</a>
                <a class="nav-link" href="#"><i class="bi bi-people"></i> Tổ chức</a>
                <a class="nav-link" href="employer_settings.php"><i class="bi bi-gear"></i> Cài đặt</a>
            </nav>
            <div class="sidebar-bottom">
                <div><b><?= htmlspecialchars($_SESSION['employer_name']) ?></b></div>
                <div style="font-size:13px;"><?= htmlspecialchars($_SESSION['employer_email'] ?? '') ?></div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-10 main-content px-5 py-4">
            <h2 class="dashboard-header">Quản lý Thông báo Tuyển dụng</h2>

            <!-- Form tạo thông báo -->
            <form action="alert_add.php" method="POST" class="mb-5">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="keyword" class="form-label">Từ khóa</label>
                        <input type="text" class="form-control" id="keyword" name="keyword" required>
                    </div>
                    <div class="col-md-4">
                        <label for="location" class="form-label">Địa điểm</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="col-md-4">
                        <label for="skills" class="form-label">Kỹ năng yêu cầu</label>
                        <input type="text" class="form-control" id="skills" name="skills" placeholder="Ví dụ: PHP, JavaScript">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Tạo Thông báo</button>
            </form>

            <!-- Danh sách thông báo -->
            <h5 class="mb-3">Danh sách Thông báo đã tạo</h5>
            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Từ khóa</th>
                        <th>Địa điểm</th>
                        <th>Kỹ năng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu giả mẫu -->
                    <tr>
                        <td>1</td>
                        <td>Lập trình PHP</td>
                        <td>Hồ Chí Minh</td>
                        <td>PHP, Laravel</td>
                        <td>
                            <a href="alert_edit.php?id=1" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="alert_delete.php?id=1" class="btn btn-sm btn-danger" onclick="return confirm('Xóa thông báo này?')">Xóa</a>
                        </td>
                    </tr>
                    <!-- Lặp dữ liệu từ CSDL tại đây -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
