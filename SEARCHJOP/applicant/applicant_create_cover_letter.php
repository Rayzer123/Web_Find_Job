<?php
session_start();
include '../db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_company = htmlspecialchars($_POST['name_company']);
    $name = htmlspecialchars($_POST['name']);
    $ngaysinh = htmlspecialchars($_POST['ngaysinh']);
    $diachinha = htmlspecialchars($_POST['diachinha']);
    $contact = htmlspecialchars($_POST['contact']);
    $position = htmlspecialchars($_POST['position']);
    $experience = nl2br(htmlspecialchars($_POST['experience']));
    $loaitotnghiep = htmlspecialchars($_POST['loaitotnghiep']);
    $university = htmlspecialchars($_POST['university']);

    $filename = "thu_xin_viec_" . time() . ".doc";
    $folder = '../Word_file/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);  // tạo thư mục nếu chưa có
    }

    $filepath = $folder . $filename;

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
        // 👉 Chỉ tải file về máy
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=$filename");
        echo $content;
        exit;
    }

    $applicant_id = $_SESSION['user_id'] ?? 0;
    if ($_POST['action'] == 'save') {
        // 👉 Chỉ lưu file lên server
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        file_put_contents($filepath, $content);

        // 👉 Lưu đường dẫn lên database
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
    <title>Thư Xin Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 30px; }
        .letter-box { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 2px 2px 15px rgba(0,0,0,0.1); max-width: 700px; margin: auto; }
        .letter-title { text-align: center; margin-bottom: 20px; font-size: 2rem; }
        .letter-footer { margin-top: 30px; text-align: right; font-weight: bold; }
    </style>
</head>
<body>

<div class="letter-box">
    <h2 class="letter-title">Thư Xin Việc</h2>
    <form action="applicant_create_cover_letter.php" method="post" class="p-4">
    <div class="mb-3">
        <label for="name_company" class="form-label">Tên công ty muốn ứng tuyển</label>
        <input type="text" class="form-control" name="name_company" required>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Họ tên</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
        <label for="ngaysinh" class="form-label">Ngày-Tháng-Năm sinh</label>
        <input type="text" class="form-control" name="ngaysinh" required>
    </div>
    <div class="mb-3">
        <label for="diachinha" class="form-label">Địa chỉ nhà</label>
        <input type="text" class="form-control" name="diachinha" required>
    </div>
    <div class="mb-3">
        <label for="contact" class="form-label">Số điện thoại hoặc Gmail</label>
        <input type="text" class="form-control" name="contact" required>
    </div>
    <div class="mb-3">
        <label for="position" class="form-label">Vị trí ứng tuyển</label>
        <input type="text" class="form-control" name="position" required>
    </div>
    <div class="mb-3">
        <label for="loaitotnghiep" class="form-label">Loại tốt nghiệp</label>
        <input type="text" class="form-control" name="loaitotnghiep" required>
    </div>
    <div class="mb-3">
        <label for="university" class="form-label">Trường Tốt Nghiệp</label>
        <input type="text" class="form-control" name="university" required>
    </div>
    <div class="mb-3">
        <label for="experience" class="form-label">Kinh nghiệm(ghi số kèm theo năm hoặc tháng)</label>
        <textarea class="form-control" name="experience" rows="3" required></textarea>
    </div>
    <button type="submit" name="action" value="download" class="btn btn-primary">Tải file về máy</button>
    <button type="submit" name="action" value="save" class="btn btn-success">Lưu file lên server</button>
</form>
</div>

</body>
</html>