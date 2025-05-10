<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Web Tìm Việc Làm</title>
    <link rel="stylesheet" href="Dangnhap.css">
    
</head>
<body>
    <div class="container">
        <h2>Đăng Nhập nhà tuyển dụng</h2>
        <form action="#" method="post">
            <input type="email" name="em" placeholder="Email" required>
            <input type="password" name="mk" placeholder="Mật khẩu" required>

            <div style="text-align: left; margin-bottom: 10px;">
                <label>
                    <input type="checkbox" name="lmk"> Lưu mật khẩu
                </label>
                <a href="./Quenmk.php" style="float: right;">Quên mật khẩu?</a>
            </div>

            <input type="submit" name="dnh" value="Đăng nhập">
            <p>Bạn là nhà tuyển dụng chưa có tài khoản?</p><a href="dangkyntd.php">Đăng ký</a>
        </form>
    </div>
</body>
</html>
<?php if (isset($_GET['success'])): ?>
    <script>alert("Đăng ký thành công! Hãy đăng nhập.");</script>
<?php endif; ?>
