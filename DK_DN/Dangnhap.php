<?php
// Xử lý đăng nhập
$thongbao = '';

if (isset($_POST['dnh'])) {
    $tendn = $_POST['em'];
    $matkh = $_POST['mk'];

    $conn = mysqli_connect("localhost", "root", "", "test") or die("Không kết nối được CSDL");

    $sql = "SELECT * FROM tbAccount2025 WHERE tendangnhap = '$tendn' AND matkhau = '$matkh'";
    $kq = mysqli_query($conn, $sql);

    if ($dong = mysqli_fetch_array($kq)) {
        header('Location: ./Giaodien/Giaodienchinh.php');
        exit();
    } else {
        $thongbao = "❌ Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="dangnhap.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Nhập</h2>
        <form method="post">
            <input type="email" name="em" placeholder="Email" required>
            <input type="password" name="mk" placeholder="Mật khẩu" required>

            <div class="remember-forgot">
                <label><input type="checkbox" name="lmk"> Lưu mật khẩu</label>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <input type="submit" name="dnh" value="Đăng nhập">

            <hr>

            <button type="button" class="btn-google">
                <img src="./img/logo_gg.jpg" alt="Google logo">
                Đăng nhập với Google
            </button>

            <p>Bạn chưa có tài khoản? <a href="Dangkynguoidung.php">Đăng ký</a></p>

            <?php
            if (!empty($thongbao)) {
                echo "<p class='error'>$thongbao</p>";
            }
            ?>
        </form>
    </div>
</body>
</html>
<?php if (isset($_GET['success'])): ?>
    <script>alert("Đăng ký thành công! Hãy đăng nhập.");</script>
<?php endif; ?>

