<?php
session_start();
include('../db_connect.php');
$employer_id = $_SESSION['employer_id'];
if(!isset($_SESSION['employer_id'])) header('Location: employer_login.php');

// Lấy thông tin nhà tuyển dụng
$stmt = $conn->prepare("SELECT * FROM employers WHERE id = ?");
$stmt->bind_param("i", $employer_id); // "i" là kiểu integer
$stmt->execute();

$result = $stmt->get_result();
$employer = $result->fetch_assoc();

$email_msg = '';
$password_msg = '';

if(isset($_POST['update_email'])) {
    $new_email = trim($_POST['new_email']);
    if(filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE employers SET email='$new_email' WHERE id=$employer_id";
        mysqli_query($conn, $sql);
        $email_msg = "<span class='text-success'>Cập nhật email thành công!</span>";
        $_SESSION['employer_email'] = $new_email;
        $employer['email'] = $new_email;
    } else {
        $email_msg = "<span class='text-danger'>Email không hợp lệ!</span>";
    }
}

if(isset($_POST['update_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    if(password_verify($current, $employer['password'])) {
        if($new === $confirm && strlen($new) >= 6) {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            mysqli_query($conn, "UPDATE employers SET password='$hash' WHERE id=$employer_id");
            $password_msg = "<span class='text-success'>Đổi mật khẩu thành công!</span>";
        } else {
            $password_msg = "<span class='text-danger'>Mật khẩu mới không khớp hoặc quá ngắn!</span>";
        }
    } else {
        $password_msg = "<span class='text-danger'>Mật khẩu hiện tại không đúng!</span>";
    }
}
if (isset($_POST['save_logo']) && isset($_FILES['logo'])) {
    $file = $_FILES['logo'];
    
    // Kiểm tra lỗi upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $file['tmp_name'];
        $name = basename($file['name']);
        $size = $file['size'];

        // Kiểm tra dung lượng (ví dụ tối đa 1MB)
        if ($size <= 5 * 1024 * 1024) {
            // Đường dẫn lưu ảnh, ví dụ thư mục uploads/
            $upload_dir = '../img/logo/';
            
            // Tạo tên file mới tránh trùng (ví dụ: userID_timestamp.ext)
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $new_name = 'logo_' . $employer_id . '_' . time() . '.' . $ext;
            $upload_path = $upload_dir . $new_name;

            // Di chuyển file từ tmp lên thư mục uploads
            if (move_uploaded_file($tmp_name, $upload_path)) {
                // Cập nhật đường dẫn ảnh trong database
                $sql = "UPDATE employers SET logo = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $new_name, $employer_id);
                $stmt->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    }
}
$logo_file = $employer['logo'] ?? '';
if (!$logo_file || !file_exists('../img/logo/' . $logo_file)) {
    $logo_file = '../logoweb.jpg'; // link ảnh mặc định
} else {
    $logo_file = '../img/logo/' . htmlspecialchars($logo_file);
    
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cài đặt tài khoản | Nhà tuyển dụng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .setting-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #eee; padding: 32px; margin-bottom: 30px; }
        .setting-title { font-size: 22px; color: #004b8d; margin-bottom: 18px; }
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
                <a class="nav-link" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                <a class="nav-link" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small">Blog</div>
                <a class="nav-link" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển dụng</a>
                <a class="nav-link" href="employer_interview.php""><i class="bi bi-chat"></i> Phỏng vấn nhiều vòng...</a>
                <div class="ps-2 pt-2 pb-1 text-secondary small"> </div>
                <a class="nav-link" href="employer_help.php"><i class="bi bi-question-circle"></i> Hỗ trợ</a>
                <a class="nav-link" href="employer_organization.php"><i class="bi bi-people"></i> Tổ chức</a>
                <a class="nav-link active" href="employer_settings.php"><i class="bi bi-gear"></i> Cài đặt</a>
            </nav>
            <div class="sidebar-bottom">
                <div><b><?= htmlspecialchars($employer['company_name']) ?></b></div>
                <div style="font-size:13px;"><?= htmlspecialchars($employer['email']) ?></div>
            </div>
        </div>
        <!-- Main -->
        <div class="col-10 main-content px-5 py-4">
            <h2 class="mb-4" style="color:#004b8d;">Cài đặt</h2>
            <div class="setting-card mb-4">
                <div class="row">
                    <!-- Bên trái: Email -->
                    <div class="col-md-6">
                        <div class="pe-3">
                            <div class="setting-title mb-2">Email</div>
                            <div class="mb-2" style="color:#444">Quản lí và thay đổi địa chỉ email cá nhân của bạn.</div>
                            <div style="font-size:16px; margin-bottom:10px;">
                                <b>Email hiện tại</b>: <?= htmlspecialchars($employer['email']) ?>
                                <span class="text-success">&#10004;</span>
                            </div>
                            <form class="row g-2 align-items-end" method="post">
                                <div class="col-auto">
                                    <input type="email" name="new_email" class="form-control" placeholder="Nhập email mới">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" name="update_email" class="btn btn-outline-primary">Cập nhật email</button>
                                </div>
                                <div class="col-12"><?= $email_msg ?></div>
                            </form>
                        </div>
                    </div>

                    <!-- Bên phải: Logo -->
                    <div class="col-md-6">
                        <div class="ps-3">
                            <form method="post" action="employer_settings.php" enctype="multipart/form-data">
                                <div class="col-md-2">
                                    <img src="<?= $logo_file ?>" alt="Logo" width="150" height="150" class="rounded-circle border">
                                </div>
                                <div class="mb-2" id="fileInputContainer" style="display: none;">
                                    <input type="file" name="logo" accept="image/*" required class="form-control">
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" id="showFileInputBtn" class="btn btn-secondary">Chọn ảnh</button>
                                    <button type="submit" name="save_logo" class="btn btn-primary" style="display: none;">Lưu ảnh</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="setting-card">
                <div class="setting-title mb-2">Mật khẩu</div>
                <div class="mb-2" style="color:#444">Thay đổi mật khẩu hiện tại của bạn.</div>
                <form method="post" class="row g-3">
                    <div class="col-md-4">
                        <input type="password" name="current_password" class="form-control" placeholder="Mật khẩu hiện tại" required>
                    </div>
                    <div class="col-md-4">
                        <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới" required>
                    </div>
                    <div class="col-md-4">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu mới" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="update_password" class="btn btn-outline-primary">Cập nhật mật khẩu</button>
                        <?= $password_msg ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
document.getElementById('showFileInputBtn').addEventListener('click', function() {
    document.getElementById('fileInputContainer').style.display = 'block';
    this.style.display = 'none'; // Ẩn nút "Chọn ảnh"
    document.querySelector('button[name="save_logo"]').style.display = 'inline-block'; // Hiện nút "Lưu ảnh"
});
</script>