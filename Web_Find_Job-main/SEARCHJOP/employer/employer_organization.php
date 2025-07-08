<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header('Location: employer_login.php');
    exit;
}

// --- Database Connection (Replace with your credentials) ---
$host = "localhost";
$username = "root";
$password = "";
$database = "findjob";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$employer_id = $_SESSION['employer_id'];

// --- Fetch company information ---
$org_query = "SELECT * FROM employers WHERE id = ?";
$org_stmt = $conn->prepare($org_query);
$org_stmt->bind_param("i", $employer_id);
$org_stmt->execute();
$org_result = $org_stmt->get_result();
$organization = $org_result->fetch_assoc();
$org_stmt->close();

// --- Handle form submission to update company info ---
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $_POST['company_name'];
    $company_description = $_POST['company_description'];
    $company_address = $_POST['company_address'];
    $company_phone = $_POST['company_phone'];
    $company_website = $_POST['company_website'];

    $update_query = "UPDATE employers SET 
                     company_name = ?, 
                     company_description = ?, 
                     company_address = ?, 
                     company_phone = ?, 
                     company_website = ? 
                     WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssi", $company_name, $company_description, $company_address, $company_phone, $company_website, $employer_id);

    if ($update_stmt->execute()) {
        $message = "Thông tin công ty đã được cập nhật.";
        header("Location: employer_organization.php"); // Refresh
        exit;
    } else {
        $message = "Lỗi khi cập nhật thông tin: " . $update_stmt->error;
    }
    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tổ chức | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* --- CSS (You can move this to a separate file) --- */
        body {
            background: #f6f8fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #e6e9ef;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:focus {
            background: #e3f1ff;
            color: #004b8d !important;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #333;
        }

        .sidebar .nav-link i {
            width: 20px;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 0;
            width: 220px;
            padding: 12px;
            font-size: 14px;
            color: #888;
        }

        .main-content {
            background: #f6f8fa;
            min-height: 100vh;
        }

        .dashboard-header {
            color: #004b8d;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px #aaa3;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #004b8d;
            border-color: #004b8d;
        }

        .btn-primary:hover {
            background-color: #003666;
            border-color: #003666;
        }
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
                    <a class="nav-link active" href="employer_organization.php"><i class="bi bi-people"></i> Tổ chức</a>
                    <a class="nav-link" href="employer_settings.php"><i class="bi bi-gear"></i> Cài đặt</a>
                </nav>
                <div class="sidebar-bottom">
                    <div><b><?= htmlspecialchars($_SESSION['employer_name']) ?></b></div>
                    <div style="font-size:13px;"><?= htmlspecialchars($_SESSION['employer_email'] ?? '') ?></div>
                </div>
            </div>

            <div class="col-10 main-content px-5 py-4">

                <h2 class="dashboard-header">Thông tin Tổ chức</h2>

                <?php if ($message): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <div class="dashboard-card">
                    <form method="post" action="employer_organization.php">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Tên công ty</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="<?= htmlspecialchars($organization['company_name'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_description" class="form-label">Mô tả công ty</label>
                            <textarea class="form-control" id="company_description" name="company_description"
                                rows="5"><?= htmlspecialchars($organization['company_description'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="company_address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="company_address" name="company_address"
                                value="<?= htmlspecialchars($organization['company_address'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="company_phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="company_phone" name="company_phone"
                                value="<?= htmlspecialchars($organization['company_phone'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="company_website" class="form-label">Website</label>
                            <input type="text" class="form-control" id="company_website" name="company_website"
                                value="<?= htmlspecialchars($organization['company_website'] ?? '') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>