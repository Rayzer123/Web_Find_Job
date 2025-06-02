<?php
session_start();
include '../db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $position = htmlspecialchars($_POST['position']);
    $experience = nl2br(htmlspecialchars($_POST['experience']));

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
    <body>
        <p>Kính gửi nhà tuyển dụng,</p>
        <p>Tôi tên là <strong>$name</strong>, xin ứng tuyển vị trí <strong>$position</strong>.</p>
        <p><strong>Kinh nghiệm:</strong> $experience</p>
        <p>Tôi rất mong được tham gia làm việc tại Quý công ty và đóng góp kỹ năng của mình cho sự phát triển chung.</p>
        <p>Trân trọng,</p>
        <p><strong>$name</strong></p>
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
        <label for="name" class="form-label">Họ tên</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
        <label for="position" class="form-label">Vị trí ứng tuyển</label>
        <input type="text" class="form-control" name="position" required>
    </div>
    <div class="mb-3">
        <label for="experience" class="form-label">Kinh nghiệm</label>
        <textarea class="form-control" name="experience" rows="3" required></textarea>
    </div>
    <button type="submit" name="action" value="download" class="btn btn-primary">Tải file về máy</button>
    <button type="submit" name="action" value="save" class="btn btn-success">Lưu file lên server</button>
</form>
</div>

</body>
</html>