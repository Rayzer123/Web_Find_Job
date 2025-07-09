<?php
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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_company = htmlspecialchars($_POST['name_company']);
    $name = htmlspecialchars($_POST['name']);
    $ngaysinh = htmlspecialchars($_POST['ngaysinh']);
    $diachinha = htmlspecialchars($_POST['diachinha']);
    $contact = htmlspecialchars($_POST['contact']);
    $position = htmlspecialchars($_POST['position']);
    $experience = nl2br(htmlspecialchars($_POST['experience'])); // Giữ nl2br để giữ định dạng xuống dòng
    $loaitotnghiep = htmlspecialchars($_POST['loaitotnghiep']);
    $university = htmlspecialchars($_POST['university']);

    $filename = "thu_xin_viec_" . time() . ".doc";
    $folder = '../Word_file/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true); // tạo thư mục nếu chưa có
    }

    $filepath = $folder . $filename;

    // Nội dung file Word HTML
    $content = "
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
        <p>Kính gửi: Ban lãnh đạo và phòng nhân sự Công ty ........$name_company................</p>

        <p>Tôi tên là: ...........$name........................................................</p>
        <p>Sinh ngày: ...........$ngaysinh.................................</p>
        <p>Chỗ ở hiện nay: .........$diachinha........................</p>
        <p>Thông tin liên lạc: ....$contact...............................</p>

        <p>Thông qua trang website của công ty, tôi biết được Quý công ty có nhu cầu tuyển dụng vị trí ....$position....</p>
        <p>Tôi có ....$experience... kinh nghiệm làm việc.<p>
        <p>Tôi cảm thấy trình độ và kỹ năng của mình phù hợp với vị trí này.</p>
        <p>Tôi mong muốn được làm việc và cống hiến cho công ty.</p>
        <p>Tôi đã tốt nghiệp loại $loaitotnghiep tại trường .............$university....................</p>
        </div>
    </body>
    </html>";

    if ($_POST['action'] == 'download') {
        // Chỉ tải file về máy
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=$filename");
        echo $content;
        exit;
    }

    if ($_POST['action'] == 'save') {
        // Chỉ lưu file lên server
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        file_put_contents($filepath, $content);

        // Lưu đường dẫn lên database
        $stmt = $conn->prepare("INSERT INTO cover_letters (user_id, content_path, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $applicant_id, $filepath);
        $stmt->execute();
        $stmt->close();

        header("Location:applicant_profile.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo Thư Xin Việc | Web Tìm Việc</title>
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
            /* max-width: 700px; */ /* Removed max-width to allow full column usage */
            margin: 0 auto; /* Adjusted margin for column layout */
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
            <div class="col-lg-8"> <div class="letter-box">
                    <h2 class="letter-title">Tạo Thư Xin Việc Mới</h2>
                    <form action="applicant_create_cover_letter.php" method="post" class="p-4">
                        <div class="mb-3">
                            <label for="name_company" class="form-label">Tên công ty muốn ứng tuyển</label>
                            <input type="text" class="form-control" name="name_company" placeholder="Ví dụ: Công ty TNHH ABC" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="name" placeholder="Ví dụ: Nguyễn Văn A" required>
                        </div>
                        <div class="mb-3">
                            <label for="ngaysinh" class="form-label">Ngày-Tháng-Năm sinh</label>
                            <input type="text" class="form-control" name="ngaysinh" placeholder="Ví dụ: 01-01-1990" required>
                        </div>
                        <div class="mb-3">
                            <label for="diachinha" class="form-label">Địa chỉ nhà</label>
                            <input type="text" class="form-control" name="diachinha" placeholder="Ví dụ: 123 Đường ABC, Quận 1, TP.HCM" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Số điện thoại hoặc Gmail</label>
                            <input type="text" class="form-control" name="contact" placeholder="Ví dụ: 0901234567 hoặc email@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí ứng tuyển</label>
                            <input type="text" class="form-control" name="position" placeholder="Ví dụ: Lập trình viên PHP" required>
                        </div>
                        <div class="mb-3">
                            <label for="loaitotnghiep" class="form-label">Loại tốt nghiệp</label>
                            <input type="text" class="form-control" name="loaitotnghiep" placeholder="Ví dụ: Giỏi, Khá" required>
                        </div>
                        <div class="mb-3">
                            <label for="university" class="form-label">Trường Tốt Nghiệp</label>
                            <input type="text" class="form-control" name="university" placeholder="Ví dụ: Đại học Quốc gia TP.HCM" required>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">Kinh nghiệm (ghi số kèm theo năm hoặc tháng)</label>
                            <textarea class="form-control" name="experience" rows="3" placeholder="Ví dụ: 3 năm kinh nghiệm trong lĩnh vực IT." required></textarea>
                        </div>
                        <button type="submit" name="action" value="download" class="btn btn-primary">Tải file về máy</button>
                        <button type="submit" name="action" value="save" class="btn btn-success ms-2">Lưu file lên server</button>
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