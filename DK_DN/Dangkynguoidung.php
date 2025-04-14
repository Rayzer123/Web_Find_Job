<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "test") or die("Không thể kết nối CSDL");

if (isset($_POST['dky'])) {
    $email = $_POST['em'];
    $matkhau = $_POST['mk'];
    $nhaplai = $_POST['nlmk'];

    // Kiểm tra mật khẩu nhập lại
    if ($matkhau !== $nhaplai) {
        $error = "Mật khẩu nhập lại không khớp!";
    } else {
        // Kiểm tra trùng tài khoản
        $check_sql = "SELECT * FROM tbAccount2025 WHERE tendangnhap = '$email'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Email đã được sử dụng. Vui lòng chọn email khác!";
        } else {
            // Thêm tài khoản mới
            $sql_insert = "INSERT INTO tbAccount2025 (tendangnhap, matkhau) VALUES ('$email', '$matkhau')";
            if (mysqli_query($conn, $sql_insert)) {
                // Chuyển sang trang đăng nhập
                header("Location: dangnhap.php?success=1");
                exit();
            } else {
                $error = "Lỗi khi đăng ký. Vui lòng thử lại.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Người Dùng</title>
    <link rel="stylesheet" href="Dangnhap.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Ký Người Dùng</h2>

        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form action="" method="post">
            <input type="email" name="em" placeholder="Email" required>
            <input type="password" name="mk" placeholder="Mật khẩu" required>
            <input type="password" name="nlmk" placeholder="Nhập lại mật khẩu" required>
            <input type="submit" name="dky" value="Đăng Ký">
        </form>

        <p>Bạn đã có tài khoản? <a href="dangnhap.php">Đăng Nhập</a></p>
    </div>
</body>
</html>
