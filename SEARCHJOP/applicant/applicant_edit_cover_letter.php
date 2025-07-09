<?php
session_start();
include '../db_connect.php'; // Đảm bảo đường dẫn này đúng

// Lấy id ứng viên (giả sử lưu trong $_SESSION)
$applicant_id = $_SESSION['user_id'] ?? 0;
$cover_letter_id = $_GET['id'] ?? 0; // Lấy ID của thư xin việc cần sửa

// Kiểm tra quyền truy cập và lấy dữ liệu thư xin việc
$cover_letter_data = null;
if ($applicant_id > 0 && $cover_letter_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM cover_letters WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cover_letter_id, $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cover_letter_data = $result->fetch_assoc();
    $stmt->close();

    if (!$cover_letter_data) {
        // Nếu không tìm thấy thư xin việc hoặc không thuộc về user này
        echo "<script>alert('Thư xin việc không tồn tại hoặc bạn không có quyền chỉnh sửa.'); window.location.href='applicant_profile.php';</script>";
        exit;
    }

    // Đọc nội dung file .doc để điền vào form (cần phân tích nội dung HTML)
    $file_content = file_get_contents($cover_letter_data['content_path']);

    // Phân tích HTML để lấy các giá trị. Đây là phần phức tạp nhất.
    // Cách đơn giản nhất là dùng biểu thức chính quy (regex) để trích xuất dữ liệu.
    // Tuy nhiên, việc này rất dễ bị lỗi nếu cấu trúc HTML thay đổi.
    // Để cho ví dụ này, tôi sẽ giả định cấu trúc cố định và dùng regex.
    // TRONG MÔI TRƯỜNG THỰC TẾ, NÊN LƯU TRỰC TIẾP CÁC TRƯỜNG VÀO CSDL RIÊNG BIỆT.

    // Khởi tạo các biến để điền vào form
    $name_company = '';
    $name = '';
    $ngaysinh = '';
    $diachinha = '';
    $contact = '';
    $position = '';
    $experience = '';
    $loaitotnghiep = '';
    $university = '';

    // Regex để trích xuất dữ liệu từ HTML
    // Điều này sẽ cần được điều chỉnh chính xác theo cấu trúc HTML bạn đã tạo trong file .doc
    // Tôi sẽ cố gắng viết regex tương đối linh hoạt, nhưng nó vẫn có thể cần điều chỉnh.
    preg_match('/Kính gửi: Ban lãnh đạo và phòng nhân sự Công ty\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $name_company = trim($matches[1]);

    preg_match('/Tôi tên là:\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $name = trim($matches[1]);

    preg_match('/Sinh ngày:\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $ngaysinh = trim($matches[1]);

    preg_match('/Chỗ ở hiện nay:\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $diachinha = trim($matches[1]);

    preg_match('/Thông tin liên lạc:\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $contact = trim($matches[1]);

    preg_match('/vị trí\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $position = trim($matches[1]);

    // Đối với experience, cần loại bỏ <p> và <br> nếu có từ nl2br
    preg_match('/Tôi có\s*\.*(.*?)\s*kinh nghiệm làm việc.\<p\>/u', $file_content, $matches);
    if (isset($matches[1])) $experience = str_replace('<br />', "\n", trim($matches[1])); // Chuyển <br /> lại thành xuống dòng

    preg_match('/tốt nghiệp loại\s*(.*?)\s*tại trường\s*\.*(.*?)\s*\.*\<\/p\>/u', $file_content, $matches);
    if (isset($matches[1])) $loaitotnghiep = trim($matches[1]);
    if (isset($matches[2])) $university = trim($matches[2]);


} else {
    echo "<script>alert('ID thư xin việc không hợp lệ.'); window.location.href='applicant_profile.php';</script>";
    exit;
}


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
        $_SESSION['user_name'] = $user_name;
    }
    $query->close();
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_company_new = htmlspecialchars($_POST['name_company']);
    $name_new = htmlspecialchars($_POST['name']);
    $ngaysinh_new = htmlspecialchars($_POST['ngaysinh']);
    $diachinha_new = htmlspecialchars($_POST['diachinha']);
    $contact_new = htmlspecialchars($_POST['contact']);
    $position_new = htmlspecialchars($_POST['position']);
    $experience_new = nl2br(htmlspecialchars($_POST['experience'])); // Giữ nl2br để giữ định dạng xuống dòng
    $loaitotnghiep_new = htmlspecialchars($_POST['loaitotnghiep']);
    $university_new = htmlspecialchars($_POST['university']);

    $filename = "thu_xin_viec_" . time() . ".doc"; // Tạo tên file mới để tránh ghi đè
    $folder = '../Word_file/';
    $filepath = $folder . $filename;

    // Nội dung file Word HTML mới
    $content_new = "
    <html>
    <head>
        <meta charset='UTF-8'>
    </head>
    <body style='font-family: Times New Roman; font-size: 14pt;'>

        <div style='text-align: center;'>
            <p><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p>
            <p><em>Độc lập - Tự do - Hạnh phúc</em></p>
            <p><strong><u>ĐƠN XIN VIỆC</u></strong></p>
        </div>
        <div style='text-align: justify;'>
        <p>Kính gửi: Ban lãnh đạo và phòng nhân sự Công ty ........$name_company_new................</p>

        <p>Tôi tên là: ...........$name_new........................................................</p>
        <p>Sinh ngày: ...........$ngaysinh_new.................................</p>
        <p>Chỗ ở hiện nay: .........$diachinha_new........................</p>
        <p>Thông tin liên lạc: ....$contact_new...............................</p>

        <p>Thông qua trang website của công ty, tôi biết được Quý công ty có nhu cầu tuyển dụng vị trí ....$position_new....</p>
        <p>Tôi có ....$experience_new... kinh nghiệm làm việc.<p>
        <p>Tôi cảm thấy trình độ và kỹ năng của mình phù hợp với vị trí này.</p>
        <p>Tôi mong muốn được làm việc và cống hiến cho công ty.</p>
        <p>Tôi đã tốt nghiệp loại $loaitotnghiep_new tại trường .............$university_new....................</p>
        </div>
    </body>
    </html>";

    if ($_POST['action'] == 'download') {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=$filename");
        echo $content_new;
        exit;
    }

    if ($_POST['action'] == 'save') {
        // Xóa file cũ trước khi tạo file mới (tùy chọn)
        if (file_exists($cover_letter_data['content_path'])) {
            unlink($cover_letter_data['content_path']);
        }
        
        file_put_contents($filepath, $content_new);

        // Cập nhật đường dẫn file mới trong database
        $stmt = $conn->prepare("UPDATE cover_letters SET content_path = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $filepath, $cover_letter_id, $applicant_id);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Thư xin việc đã được cập nhật thành công!'); window.location.href='applicant_profile.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Thư Xin Việc | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .letter-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 2px 2px 15px rgba(0,0,0,0.1);
            margin: 0 auto;
            box-sizing: border-box;
        }
        .letter-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #003366;
            font-weight: 700;
        }

        /* Styles for job suggestion box */
        .profile-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}

        /* CSS cho Navbar */
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
        }
        .navbar-brand img {
            height: 34px;
        }
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

        /* CSS cho Footer */
        .footer {
            background: #09223b;
            color: #fff;
            padding: 48px 0 24px 0;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .footer .footer-col {
            margin-bottom: 24px;
        }
        .footer .footer-title {
            font-weight: 600;
            color: #ffb800;
            margin-bottom: 15px;
        }
        .footer ul {
            padding-left: 0;
            list-style: none;
        }
        .footer ul li {
            margin-bottom: 8px;
        }
        .footer .bi {
            font-size: 1.2rem;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include 'navbar_applicant.php'; ?>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="letter-box">
                    <h2 class="letter-title">Chỉnh Sửa Thư Xin Việc</h2>
                    <form action="applicant_edit_cover_letter.php?id=<?= $cover_letter_id ?>" method="post" class="p-4">
                        <div class="mb-3">
                            <label for="name_company" class="form-label">Tên công ty muốn ứng tuyển</label>
                            <input type="text" class="form-control" name="name_company" placeholder="Ví dụ: Công ty TNHH ABC" value="<?= htmlspecialchars($name_company) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="name" placeholder="Ví dụ: Nguyễn Văn A" value="<?= htmlspecialchars($name) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ngaysinh" class="form-label">Ngày-Tháng-Năm sinh</label>
                            <input type="text" class="form-control" name="ngaysinh" placeholder="Ví dụ: 01-01-1990" value="<?= htmlspecialchars($ngaysinh) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="diachinha" class="form-label">Địa chỉ nhà</label>
                            <input type="text" class="form-control" name="diachinha" placeholder="Ví dụ: 123 Đường ABC, Quận 1, TP.HCM" value="<?= htmlspecialchars($diachinha) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Số điện thoại hoặc Gmail</label>
                            <input type="text" class="form-control" name="contact" placeholder="Ví dụ: 0901234567 hoặc email@example.com" value="<?= htmlspecialchars($contact) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí ứng tuyển</label>
                            <input type="text" class="form-control" name="position" placeholder="Ví dụ: Lập trình viên PHP" value="<?= htmlspecialchars($position) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="loaitotnghiep" class="form-label">Loại tốt nghiệp</label>
                            <input type="text" class="form-control" name="loaitotnghiep" placeholder="Ví dụ: Giỏi, Khá" value="<?= htmlspecialchars($loaitotnghiep) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="university" class="form-label">Trường Tốt Nghiệp</label>
                            <input type="text" class="form-control" name="university" placeholder="Ví dụ: Đại học Quốc gia TP.HCM" value="<?= htmlspecialchars($university) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">Kinh nghiệm (ghi số kèm theo năm hoặc tháng)</label>
                            <textarea class="form-control" name="experience" rows="3" placeholder="Ví dụ: 3 năm kinh nghiệm trong lĩnh vực IT." required><?= htmlspecialchars($experience) ?></textarea>
                        </div>
                        <button type="submit" name="action" value="download" class="btn btn-primary">Tải file về máy</button>
                        <button type="submit" name="action" value="save" class="btn btn-success ms-2">Lưu thay đổi</button>
                        <a href="applicant_profile.php" class="btn btn-secondary ms-2">Hủy</a>
                    </form>
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