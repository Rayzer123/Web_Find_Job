<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header("Location: employer_login.php");
    exit();
}
include('../db_connect.php');

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['job_title'];
    $description = $_POST['job_description'];
    $location = $_POST['job_location'];
    $salary = $_POST['salary'];
    $job_type = $_POST['job_type'];
    $employer_id = $_SESSION['employer_id'];

    $sql = "INSERT INTO jobs (title, description, location, salary, job_type, employer_id, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $title, $description, $location, $salary, $job_type, $employer_id);

    if (mysqli_stmt_execute($stmt)) {
        $success = "Đăng tin tuyển dụng thành công!";
    } else {
        $error = "Lỗi khi đăng tin: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Tuyển dụng | Web Tìm Việc</title>
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
               <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                    <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" class="me-2" alt="Logo" width="60" height="60"> Web Tìm Việc
                </a>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="employer_dashboard.php"><i class="bi bi-person"></i> My Web</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Công Việc</div>
                <a class="nav-link" href="employer_jobs.php"><i class="bi bi-briefcase"></i> Công việc của tôi</a>
                <a class="nav-link active" href="employer_post_job.php"><i class="bi bi-plus-square"></i> Đăng Tuyển dụng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Ứng viên của tôi</div>
                <a class="nav-link" href="employer_search.php"><i class="bi bi-search"></i> Tìm kiếm tài năng</a>
                <a class="nav-link" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                <a class="nav-link" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
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
            <h2 class="dashboard-header">Đăng tin tuyển dụng mới</h2>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="job_title" class="form-label">Tiêu đề công việc</label>
                    <input type="text" class="form-control" id="job_title" name="job_title" required>
                </div>
                <div class="mb-3">
                    <label for="job_description" class="form-label">Mô tả công việc</label>
                    <textarea class="form-control" id="job_description" name="job_description" rows="6" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="job_location" class="form-label">Địa điểm làm việc</label>
                    <input type="text" class="form-control" id="job_location" name="job_location" required>
                </div>
                <div class="mb-3">
                    <label for="salary" class="form-label">Mức lương</label>
                    <input type="text" class="form-control" id="salary" name="salary" required>
                </div>
                <div class="mb-3">
                    <label for="job_type" class="form-label">Loại công việc</label>
                    <select class="form-select" id="job_type" name="job_type" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="Toàn thời gian">Toàn thời gian</option>
                        <option value="Bán thời gian">Bán thời gian</option>
                        <option value="Thực tập">Thực tập</option>
                        <option value="Freelance">Freelance</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Đăng tin</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
