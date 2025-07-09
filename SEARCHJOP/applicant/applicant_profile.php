<?php
// Hồ sơ xin việc (trang quản lý CV, Thư xin việc)
session_start();
include '../db_connect.php'; // Đảm bảo đường dẫn này đúng

// Lấy id ứng viên (giả sử lưu trong $_SESSION)
$applicant_id = $_SESSION['user_id'] ?? 0;

// Lấy tên người dùng từ bảng users để sử dụng cho navbar
$user_name = '';
if ($applicant_id > 0) {
    $query = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $query->bind_param("i", $applicant_id);
    $query->execute();
    $result = $query->get_result();
    $account = $result->fetch_assoc();
    if ($account) {
        $user_name = $account['name'];
        // Lưu tên người dùng vào session để navbar có thể truy cập
        $_SESSION['user_name'] = $user_name;
    }
    $query->close();
}

// --- Logic xử lý Hồ sơ (Resumes) ---
$resumes = [];
if($applicant_id > 0){
    $stmt = $conn->prepare("SELECT id, user_id, profession, experience, education, language FROM resumes WHERE user_id = ?");
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $resumes[] = $row;
    }
    $stmt->close();
}

if (isset($_POST['delete']) && !empty($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM resumes WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Đã xóa hồ sơ thành công!'); window.location.href='applicant_profile.php';</script>";
        exit;
    }
    $stmt->close();
}

if (isset($_POST['add'])) { // Changed name to avoid conflict if 'add' is used elsewhere
    header("Location:applicant_create_resume.php");
    exit;
}

// --- Logic xử lý Thư xin việc (Cover Letters) ---
$cover_letters = [];
if($applicant_id > 0){
    $stmt = $conn->prepare("SELECT id, user_id, content_path FROM cover_letters WHERE user_id = ?");
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $cover_letters[] = $row;
    }
    $stmt->close();
}

// Xử lý xóa thư xin việc
if(isset($_POST['delete1']) && isset($_POST['delete_cover_letter_id'])){
    $delete_cl_id = (int)$_POST['delete_cover_letter_id'];
    $stmt = $conn->prepare("DELETE FROM cover_letters WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_cl_id, $applicant_id);

    if ($stmt->execute()) {
        echo "<script>alert('Đã xóa thư xin việc thành công!'); window.location.href='applicant_profile.php';</script>";
        exit;
    }
    $stmt->close();
}

// Xử lý xem thư xin việc
if(isset($_POST['watch']) && isset($_POST['watch_cover_letter_id'])){
    $watch_cl_id = (int)$_POST['watch_cover_letter_id'];
    $sql = "SELECT content_path FROM cover_letters WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $watch_cl_id, $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $filePath = $row['content_path'];
        $filename = basename($filePath);

        // Ensure the file exists before attempting to read it
        if (file_exists($filePath)) {
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Length: " . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            echo "<script>alert('File thư xin việc không tồn tại.'); window.location.href='applicant_profile.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Không tìm thấy thư xin việc.'); window.location.href='applicant_profile.php';</script>";
        exit;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ xin việc của tôi | Web Tìm Việc</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa;}
        .profile-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .empty-box {border: 2px dashed #bcd8f8; border-radius: 16px; padding: 32px 0; text-align: center; background: #fafdff;}
        .empty-box .icon {font-size: 2.8rem; color: #85b8e6; margin-bottom: 12px;}
        .btn-create {margin-top: 10px;}
        .section-title {font-weight: 700; font-size: 1.5rem; color: #003366;}
    </style>
</head>
<body>
    <?php include 'navbar_applicant.php'; ?>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="profile-box mb-4">
                    <div class="section-title mb-3">Hồ sơ xin việc (<?= count($resumes) ?>)</div>
                    <?php if(empty($resumes)): ?>
                        <div class="empty-box">
                            <div class="icon">📄</div>
                            Hiện tại bạn chưa có hồ sơ nào, xin hãy chọn nút "Tạo hồ sơ mới" để tạo hồ sơ cho bạn.<br>
                            <a href="applicant_create_resume.php" class="btn btn-outline-primary btn-create">+ Tạo hồ sơ mới</a>
                        </div>
                    <?php else: ?>
                        <div style="max-height: 190px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                            <?php foreach($resumes as $resume): ?>
                                <div class="resume-item mb-3 p-3 border rounded">
                                    <strong>Ngành nghề:</strong> <?= htmlspecialchars($resume['profession']) ?><br>
                                    <strong>Kinh nghiệm:</strong> <?= htmlspecialchars($resume['experience']) ?><br>
                                    <strong>Học vấn:</strong> <?= htmlspecialchars($resume['education']) ?><br>
                                    <strong>Ngôn ngữ:</strong> <?= htmlspecialchars($resume['language']) ?><br>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?= $resume['id'] ?>">
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Xóa</button>
                                        <button type="submit" name="add" class="btn btn-danger btn-sm">Thêm</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="profile-box">
                    <div class="section-title mb-3">Thư xin việc (<?= count($cover_letters) ?>)</div>
                    <?php if(empty($cover_letters)): ?>
                        <div class="empty-box">
                            <div class="icon">✉️</div>
                            Hiện tại bạn chưa có thư xin việc nào, xin hãy chọn nút "Tạo hồ sơ mới".<br>
                            <a href="applicant_create_cover_letter.php" class="btn btn-outline-primary btn-create">+ Tạo hồ sơ mới</a>
                        </div>
                    <?php else: ?>
                        <?php
                        // Lấy thư xin việc đầu tiên để hiển thị nút Sửa/Xem/Xóa
                        $first_cover_letter = $cover_letters[0];
                        ?>
                        <div class="resume-item mb-3 p-3 border rounded">
                            <strong>Thư xin việc của bạn</strong>
                            <form method="post" style="display:inline;" action="">
                                <input type="hidden" name="delete_cover_letter_id" value="<?= $first_cover_letter['id'] ?>">
                                <button type="submit" name="delete1" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                            <form method="post" style="display:inline;" action="">
                                <input type="hidden" name="watch_cover_letter_id" value="<?= $first_cover_letter['id'] ?>">
                                <button type="submit" name="watch" class="btn btn-info btn-sm">Xem</button>
                            </form>
                            <a href="applicant_edit_cover_letter.php?id=<?= $first_cover_letter['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        </div>
                    <?php endif; ?>
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