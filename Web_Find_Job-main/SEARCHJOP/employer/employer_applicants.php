<?php
session_start();
include('../db_connect.php');
if(!isset($_SESSION['employer_id'])) header('Location: employer_login.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thư xin việc đã nhận | Nhà tuyển dụng</title>
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
        .table-empty {
            text-align: center; padding: 48px 0;
        }
        .table-empty i { font-size: 64px; color: #d2dbe6; }
        .table-empty p { color: #555; margin-top: 18px; margin-bottom: 12px; }
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
                <a class="nav-link" href="employer_dashboard.php"><i class="bi bi-person"></i> My CareerLink</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Công Việc</div>
                <a class="nav-link" href="employer_jobs.php"><i class="bi bi-briefcase"></i> Công việc của tôi</a>
                <a class="nav-link" href="employer_post_job.php"><i class="bi bi-plus-square"></i> Đăng Tuyển dụng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Ứng viên của tôi</div>
                <a class="nav-link" href="employer_search.php"><i class="bi bi-search"></i> Tìm kiếm tài năng</a>
                <a class="nav-link active" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                <a class="nav-link" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Blog</div>
                <a class="nav-link" href=""><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển dụng</a>
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
            <h2 class="mb-4" style="color:#004b8d;">Thư xin việc đã nhận</h2>
            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <select class="form-select">
                        <option>Không tìm thấy việc làm nào</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="employer_jobs.php" class="btn btn-outline-primary">Xem công việc <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-outline-secondary">Xuất báo cáo thư xin việc</button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="bg-white rounded p-3 mb-2 text-center">Tổng số ứng viên<br><span class="fw-bold text-primary fs-4">0</span></div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white rounded p-3 mb-2 text-center">Tổng số lượt xem<br><span class="fw-bold text-primary fs-4">0</span></div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white rounded p-3 mb-2 text-center">Ngày đăng<br><span class="fw-bold text-primary fs-4">N/A</span></div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white rounded p-3 mb-2 text-center">Thành viên được giao<br><span class="fw-bold text-primary fs-4">N/A</span></div>
                </div>
            </div>
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>Thư xin việc</th>
                        <th>Nhận lúc</th>
                        <th>Trạng thái</th>
                        <th>Loại</th>
                        <th>Ghi chú</th>
                        <th>Tin nhắn</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="table-empty">
                            <i class="bi bi-file-earmark-text"></i>
                            <p>Chưa có ứng viên nào ứng tuyển</p>
                            <a href="employer_search.php" class="btn btn-primary">Tìm ứng viên ngay</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>