<?php
session_start();
include '../db_connect.php'; // Đảm bảo đường dẫn này đúng

// Lấy id ứng viên (giả sử lưu trong $_SESSION)
$applicant_id = $_SESSION['user_id'] ?? 0;

// Lấy tên người dùng từ bảng users để sử dụng cho trường 'users' trong resumes
$user_name = '';
if ($applicant_id > 0) {
    $query = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $query->bind_param("i", $applicant_id);
    $query->execute();
    $result = $query->get_result();
    $account = $result->fetch_assoc();
    if ($account) {
        $user_name = $account['name'];
    }
    $query->close();
}

// Xử lý tạo hồ sơ mới
if (isset($_POST['create_resume'])) { // Đổi tên nút submit để rõ ràng hơn
    $u_id = $applicant_id;
    $user = $user_name; // Sử dụng tên người dùng đã lấy ở trên
    $profession = $_POST['profession'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];
    $language = $_POST['language'];

    $sql = "INSERT INTO resumes (user_id, users, profession, experience, education, language) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $u_id, $user, $profession, $experience, $education, $language);

    if ($stmt->execute()) {
        // Chuyển hướng về trang hồ sơ sau khi tạo thành công
        header("Location: applicant_profile.php?status=success_create_resume");
        exit;
    } else {
        // Xử lý lỗi nếu có
        $error_message = "Lỗi khi tạo hồ sơ: " . $stmt->error;
    }
    $stmt->close();
}

// Các phần xử lý khác của applicant_profile.php không cần thiết ở đây,
// nhưng tôi giữ lại cấu trúc và các include để bạn dễ hình dung.
// Nếu bạn chỉ muốn form tạo, có thể xóa bớt các phần không liên quan.

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo Hồ sơ mới | Web Tìm Việc</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa;}
        .profile-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .empty-box {border: 2px dashed #bcd8f8; border-radius: 16px; padding: 32px 0; text-align: center; background: #fafdff;}
        .empty-box .icon {font-size: 2.8rem; color: #85b8e6; margin-bottom: 12px;}
        .btn-create {margin-top: 10px;}
        .section-title {font-weight: 700; font-size: 1.5rem; color: #003366;}
        /* CSS cho avatar trong navbar, nên được định nghĩa trong một file CSS chung */
        .avatar-circle { 
            width:38px; 
            height:38px; 
            border-radius:50%; 
            background:#004b8d; 
            color:#fff; 
            font-weight:700; 
            font-size:20px; 
            display:flex; 
            align-items:center; 
            justify-content:center;
        }
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>

<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="profile-box mb-4">
                <div class="section-title mb-3">Tạo Hồ sơ xin việc mới</div>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="profession" class="form-label">Ngành nghề</label>
                        <input type="text" name="profession" id="profession" class="form-control" placeholder="Ví dụ: Lập trình viên, Kế toán" required>
                    </div>
                    <div class="mb-3">
                        <label for="experience" class="form-label">Kinh nghiệm làm việc</label>
                        <input type="text" name="experience" id="experience" class="form-control" placeholder="Ví dụ: 3 năm kinh nghiệm lập trình PHP" required>
                    </div>
                    <div class="mb-3">
                        <label for="education" class="form-label">Trình độ học vấn</label>
                        <input type="text" name="education" id="education" class="form-control" placeholder="Ví dụ: Cử nhân Công nghệ thông tin" required>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Trình độ ngoại ngữ</label>
                        <input type="text" name="language" id="language" class="form-control" placeholder="Ví dụ: Tiếng Anh (B2), Tiếng Nhật (N3)" required>
                    </div>
                    <button type="submit" name="create_resume" class="btn btn-primary">Tạo hồ sơ</button>
                    <a href="applicant_profile.php" class="btn btn-secondary ms-2">Hủy</a>
                </form>
            </div>
            <div class="profile-box">
                <div class="section-title mb-3">Thư xin việc</div>
                <div class="empty-box">
                    <div class="icon">✉️</div>
                    Bạn có thể tạo thư xin việc để tăng khả năng được tuyển dụng.<br>
                    <a href="applicant_create_cover_letter.php" class="btn btn-outline-primary btn-create">+ Tạo thư xin việc mới</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="profile-box mb-4">
                <b>Gợi ý việc làm</b>
                <hr>
                <div class="small text-muted">Dựa trên việc làm đã xem. <a href="#">Xóa lịch sử việc làm đã xem</a></div>
                <div class="mt-2">
                    <div>
                        <a href="#" class="fw-bold">Nhân Viên Phòng Hợp Đồng (Tiếng Trung)</a><br>
                        <span class="small text-muted">CÔNG TY TNHH XÂY DỰNG TRUNG QUỐC</span><br>
                        <span class="small"><i class="bi bi-geo-alt"></i> Hồ Chí Minh</span><br>
                        <span class="text-primary small">Thương lượng</span>
                    </div>
                    <hr>
                    <div>
                        <a href="#" class="fw-bold">Nhân Viên Văn Phòng - Biết Tiếng Trung</a><br>
                        <span class="small text-muted">CÔNG TY CỔ PHẦN TẬP ĐOÀN VGI</span><br>
                        <span class="small"><i class="bi bi-geo-alt"></i> Hồ Chí Minh</span><br>
                        <span class="text-primary small">Thương lượng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>