<?php
// Trang tài khoản/thông tin cá nhân
session_start();
include '../db_connect.php';

$applicant_id = $_SESSION['user_id'] ?? 0;
// Lấy thông tin tài khoản từ DB
$query = $conn->prepare("SELECT name, email, phone, gender, dob, marital_status, address, created_at, avatar FROM users WHERE id = ?");
$query->bind_param("i", $applicant_id);
$query->execute();
$result = $query->get_result();
$account = $result->fetch_assoc();

if (!$account) {
    // Nếu không tìm thấy user, gán giá trị rỗng
    $account = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'gender' => '',
        'dob' => '',
        'marital_status' => '',
        'address' => ''
    ];
}

// Khi bấm nút lưu
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $address = $_POST['address'];
    $created_at = $account['created_at'];

    // Update vào database
    $update = $conn->prepare("
        UPDATE users SET 
            name = ?, 
            email = ?, 
            phone = ?, 
            gender = ?, 
            dob = ?, 
            marital_status = ?, 
            address = ?
        WHERE id = ?
    ");
    $update->bind_param("sssssssi", $name, $email, $phone, $gender, $dob, $marital_status, $address, $applicant_id);
    if ($update->execute()) {
        $message = "Cập nhật thành công!";
        // Lấy lại dữ liệu mới từ DB
        $account = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'dob' => $dob,
            'marital_status' => $marital_status,
            'address' => $address,
            'created_at' => $created_at
        ];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $message = "Cập nhật thất bại: " . $conn->error;
    }
}
if (isset($_POST['save_avatar']) && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    
    // Kiểm tra lỗi upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $file['tmp_name'];
        $name = basename($file['name']);
        $size = $file['size'];

        // Kiểm tra dung lượng (ví dụ tối đa 1MB)
        if ($size <= 5 * 1024 * 1024) {
            // Đường dẫn lưu ảnh, ví dụ thư mục uploads/
            $upload_dir = '../img/avatar/';
            
            // Tạo tên file mới tránh trùng (ví dụ: userID_timestamp.ext)
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $new_name = 'avatar_' . $applicant_id . '_' . time() . '.' . $ext;
            $upload_path = $upload_dir . $new_name;

            // Di chuyển file từ tmp lên thư mục uploads
            if (move_uploaded_file($tmp_name, $upload_path)) {
                // Cập nhật đường dẫn ảnh trong database
                $sql = "UPDATE users SET avatar = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $new_name, $applicant_id);
                $stmt->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    }
}
$avatar_file = $account['avatar'] ?? '';
if (!$avatar_file || !file_exists('../img/avatar/' . $avatar_file)) {
    $avatar_file = '../logoweb.jpg'; // link ảnh mặc định
} else {
    $avatar_file = '../img/avatar/' . htmlspecialchars($avatar_file);
}
if (isset($_POST['delete_account'])) {
    $applicant_id = $_SESSION['user_id'] ?? 0;

    if ($applicant_id) {
        // Xóa user khỏi database
        $delete = $conn->prepare("DELETE FROM users WHERE id = ?");
        $delete->bind_param("i", $applicant_id);
        if ($delete->execute()) {
            // Xóa session
            session_destroy();

            // Chuyển hướng ra trang login
            header('Location: index.php?message=Tài khoản đã được xóa');
            exit;
        } else {
            echo "<script>alert('Xóa tài khoản thất bại: " . $conn->error . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tài khoản ứng viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body { background: #f6f8fa;}
        .account-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .section-title {font-weight: 700; font-size: 1.5rem; color: #003366;}
        .avatar {width:80px;height:80px;border-radius:50%;background:#e3e5e7;display:flex;align-items:center;justify-content:center;font-size:2.2rem;}
        .info-label {color:#888;}
        .edit-link {color:#1a7cdf;text-decoration:none;}
        .edit-link:hover {text-decoration:underline;}
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>
<div class="container my-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="account-box">
                <h6 class="fw-bold mb-3">Tài khoản</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a class="nav-link active" href="#">Tài khoản</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="#">Đổi mật khẩu</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="account-box">
                <div class="section-title mb-3">Tài khoản</div>
                <p>Hãy cập nhật thông tin mới nhất.<br>
                Thông tin cá nhân dưới đây sẽ tự động điền khi bạn tạo hồ sơ mới.</p>
                <div class="row align-items-center mb-4">
                    <div class="col-md-2">
                        <img src="<?= $avatar_file ?>" alt="Avatar" width="150" height="150" class="rounded-circle border">
                    </div>
                    <div class="col-md-10 d-flex align-items-center">
                        <form method="post" action="applicant_account.php" enctype="multipart/form-data" class="d-flex gap-2">
                            <div id="fileInputContainer" style="display: none;">
                                <input type="file" name="avatar" accept="image/*" required>
                            </div>
                            <button type="button" id="showFileInputBtn" class="btn btn-secondary">Chọn ảnh</button>
                            <button type="submit" name="save_avatar" class="btn btn-primary" style="display: none;">Lưu ảnh</button>
                        </form>
                    </div>
                </div>
                <form method="post" action="applicant_account.php">
                    <table class="table">
                        <tr>
                            <td>Họ và tên *</td>
                            <td><input type="text" name="name" value="<?= htmlspecialchars($account['name']) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ email *</td>
                            <td><input type="email" name="email" value="<?= htmlspecialchars($account['email']) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Số điện thoại</td>
                            <td><input type="text" name="phone" value="<?= htmlspecialchars($account['phone']) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Giới tính</td>
                            <td>
                                <select name="gender" class="form-select">
                                    <option value="Nam" <?= $account['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?= $account['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                                    <option value="" <?= $account['gender'] == '' ? 'selected' : '' ?>>Khác</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Ngày sinh</td>
                            <td><input type="date" name="dob" value="<?= htmlspecialchars($account['dob']) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Tình trạng hôn nhân</td>
                            <td>
                                <select name="marital_status" class="form-select">
                                    <option value="Độc thân" <?= $account['marital_status'] == 'Độc thân' ? 'selected' : '' ?>>Độc thân</option>
                                    <option value="Đã kết hôn" <?= $account['marital_status'] == 'Đã kết hôn' ? 'selected' : '' ?>>Đã kết hôn</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td><input type="text" name="address" value="<?= htmlspecialchars($account['address']) ?>" class="form-control"></td>
                        </tr>
                    </table>
                    <button type="submit" name="save" class="btn btn-primary">Lưu thông tin</button>
                </form>
                <div class="text-end text-muted small">Ngày đăng ký: <?= $account['created_at'] ?></div>
               <form action="applicant_account.php" method="post" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản?');">
                    <button type="submit" name="delete_account" class="btn btn-danger">➖ Xóa tài khoản</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
</body>
</html>

<script>
document.getElementById('showFileInputBtn').addEventListener('click', function() {
    document.getElementById('fileInputContainer').style.display = 'block';
    this.style.display = 'none'; // Ẩn nút "Chọn ảnh"
    document.querySelector('button[name="save_avatar"]').style.display = 'inline-block'; // Hiện nút "Lưu ảnh"
});
</script>