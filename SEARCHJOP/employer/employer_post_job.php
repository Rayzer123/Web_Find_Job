<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header("Location: employer_login.php");
    exit();
}
include('../db_connect.php'); // Đảm bảo đường dẫn này đúng tới file kết nối CSDL của bạn

$success = '';
$error = '';
$posted_time = '';     // Biến để lưu thời gian đăng tin
$expiration_time = ''; // Biến để lưu thời gian hết hạn

// Không cần lấy $company_name từ session nữa vì nó sẽ được nhập từ form

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy tên công ty từ form POST
    $company_name = $_POST['company_name']; 

    $title = $_POST['job_title'];
    $description = $_POST['job_description'];
    $location = $_POST['job_location'];
    $salary = $_POST['salary'];
    $job_type = $_POST['job_type'];
    $display_duration = $_POST['display_duration'];
    $years_experience = $_POST['years_experience'];
    $employer_id = $_SESSION['employer_id'];

    // Cập nhật câu lệnh SQL để chèn cột company_name
    $sql = "INSERT INTO jobs (title, description, location, salary, job_type, display_duration, years_experience, employer_id, company_name, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        $error = "Lỗi chuẩn bị câu lệnh SQL: " . mysqli_error($conn);
    } else {
        // Cập nhật chuỗi định dạng cho mysqli_stmt_bind_param
        // Thêm 's' cho $company_name (string)
        mysqli_stmt_bind_param($stmt, "sssssiiis", $title, $description, $location, $salary, $job_type, $display_duration, $years_experience, $employer_id, $company_name);

        if (mysqli_stmt_execute($stmt)) {
            $current_timestamp = time(); 
            $posted_time = date('H:i:s d/m/Y', $current_timestamp); 

            $expiration_timestamp = strtotime("+" . $display_duration . " days", $current_timestamp);
            $expiration_time = date('H:i:s d/m/Y', $expiration_timestamp);

            $success = "Đăng tin tuyển dụng thành công vào lúc: **" . $posted_time . "**!<br>";
            $success .= "Tin sẽ hết hạn vào lúc: **" . $expiration_time . "**.";

        } else {
            $error = "Lỗi khi đăng tin: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Tuyển dụng | Web Tìm Việc</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        <div class="col-10 main-content px-5 py-4">
            <h2 class="dashboard-header">Đăng tin tuyển dụng mới</h2>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="company_name" class="form-label">Tên công ty</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" required>
                    <div class="form-text">Nhập tên công ty sẽ hiển thị trên tin tuyển dụng này.</div>
                </div>

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
                
                <div class="mb-3">
                    <label for="display_duration" class="form-label">Thời gian hiển thị (ngày)</label>
                    <input type="number" class="form-control" id="display_duration" name="display_duration" min="1" value="30" required>
                    <div class="form-text">Số ngày tin tuyển dụng sẽ hiển thị công khai.</div>
                </div>

                <div class="mb-3">
                    <label for="years_experience" class="form-label">Năm kinh nghiệm yêu cầu</label>
                    <select class="form-select" id="years_experience" name="years_experience" required>
                        <option value="">-- Chọn kinh nghiệm --</option>
                        <option value="0">Không yêu cầu kinh nghiệm</option>
                        <option value="1">1 năm</option>
                        <option value="2">2 năm</option>
                        <option value="3">3 năm</option>
                        <option value="4">4 năm</option>
                        <option value="5">5 năm trở lên</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Đăng tin</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>