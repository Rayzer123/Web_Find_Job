<?php
// Dữ liệu mẫu cho Quốc gia, Tỉnh/Thành, Quận/Huyện
$dsTinhThanh = [
    'Việt Nam' => ['Hà Nội', 'TP. Hồ Chí Minh'],
];

$dsQuanHuyen = [
    'Hà Nội' => ['Cầu Giấy', 'Thanh Xuân', 'Hoàng Mai', 'Đống Đa', 'Hà Đông', 'Hai Bà Trưng',
     'Ba Đình', 'Hoàn Kiếm', 'Long Biên', 'Tây Hồ', 'Nam Từ Liêm và Bắc Từ Liêm'],
    'TP. Hồ Chí Minh' => ['Quận 1', 'Quận 3','Quận 4', 'Quận 5', 'Quận 6', 'Quận 7', 'Quận 8', 'Quận 10', 'Quận 11', 'Quận 12',
    'Quận Tân Bình', 'Quận Bình Tân', 'Quận Bình Thạnh', 'Quận Tân Phú', 'Quận Gò Vấp', 'Quận Phú Nhuận',
    'Bình Chánh', 'Hóc Môn', 'Cần Giờ', 'Củ Chi', 'Nhà Bè']
];

// Nhận dữ liệu từ form
$email = $_POST['tke'] ?? '';
$matkhau = $_POST['mk'] ?? '';
$nhapLai = $_POST['nlmk'] ?? '';
$tenCongTy = $_POST['ten-cong-ty'] ?? '';
$soNhanVien = $_POST['so-nhan-vien'] ?? '';
$nguoiLienHe = $_POST['nguoi-lien-he'] ?? '';
$dienThoai = $_POST['dien-thoai'] ?? '';
$quocGia = $_POST['quoc-gia'] ?? '';
$tinhThanh = $_POST['tinh-thanh'] ?? '';
$quanHuyen = $_POST['quan-huyen'] ?? '';
$soNhaPhuongXa = $_POST['so-nha-phuong-xa'] ?? '';

$error = "";

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tke'])) {
    if ($matkhau != $nhapLai) {
        $error = "❌ Mật khẩu nhập lại không khớp.";
    } elseif (empty($tenCongTy)) {
        $error = "❌ Vui lòng nhập tên công ty.";
    } else {
        // Kết nối CSDL (sử dụng cơ sở dữ liệu tên là 'test', bạn có thể thay đổi)
        $conn = mysqli_connect("localhost", "root", "", "test") or die("Không kết nối được CSDL");

        // Kiểm tra tài khoản đã tồn tại
        $check_sql = "SELECT * FROM tbNTD WHERE email = '$email'";
        $check_kq = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($check_kq) > 0) {
            $error = "❌ Email đã được sử dụng.";
        } else {
            // Thêm dữ liệu vào bảng Nhà Tuyển Dụng
            $sql = "INSERT INTO tbNTD (email, matkhau, tencongty, sonhanvien, nguoilienhe, dienthoai, quocgia, tinhthanh, quanhuyen, diachi) 
                    VALUES ('$email', '$matkhau', '$tenCongTy', '$soNhanVien', '$nguoiLienHe', '$dienThoai', '$quocGia', '$tinhThanh', '$quanHuyen', '$soNhaPhuongXa')";
            if (mysqli_query($conn, $sql)) {
                // Chuyển hướng sang trang đăng nhập NTD
                header("Location: Dangnhapntd.php?success=1");
                exit();
            } else {
                $error = "❌ Lỗi đăng ký: " . mysqli_error($conn);
            }
        }
    }
}

 // Chỉ xử lý đăng ký khi người dùng nhấn nút gửi
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tke"])) {
    // Kiểm tra các trường bắt buộc
    if (
        !empty($_POST["tke"]) &&
        !empty($_POST["mk"]) &&
        !empty($_POST["nlmk"]) &&
        !empty($_POST["ten-cong-ty"]) &&
        !empty($_POST["so-nhan-vien"]) &&
        !empty($_POST["nguoi-lien-he"]) &&
        !empty($_POST["dien-thoai"]) &&
        !empty($_POST["quoc-gia"]) &&
        !empty($_POST["tinh-thanh"]) &&
        !empty($_POST["quan-huyen"]) &&
        !empty($_POST["so-nha-phuong-xa"])
    ) {
        // Nếu dữ liệu hợp lệ
        // TODO: Thêm xử lý ghi CSDL ở đây nếu muốn

        header("Location: Dangnhapntd.php");
        exit();
    } else {
        echo "<p style='color:red; text-align:center;'>Vui lòng nhập đầy đủ thông tin!</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Nhà Tuyển Dụng</title>
    <link rel="stylesheet" href="dkntd.css">
</head>
<body>
<div class="form-container">
    <h2 align="center">Đăng Ký Nhà Tuyển Dụng</h2>

    <?php if (!empty($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>

    <form method="post">
        <input type="email" name="tke" value="<?= $email ?>" placeholder="Email" required>
        <input type="password" name="mk" placeholder="Mật khẩu" required>
        <input type="password" name="nlmk" placeholder="Nhập lại mật khẩu" required>

        <h3 align="center">Thông Tin Công Ty</h3>
        <input type="text" name="ten-cong-ty" value="<?= $tenCongTy ?>" placeholder="Tên công ty" required>
        <input type="number" name="so-nhan-vien" value="<?= $soNhanVien ?>" placeholder="Số nhân viên">
        <input type="text" name="nguoi-lien-he" value="<?= $nguoiLienHe ?>" placeholder="Người liên hệ">
        <input type="tel" name="dien-thoai" value="<?= $dienThoai ?>" placeholder="Số điện thoại">

        <label for="dia-chi">Địa Chỉ</label>

<!-- Quốc gia -->
<select name="quoc-gia" onchange="this.form">
    <option value="">Chọn quốc gia</option>
    <option value="Việt Nam" <?= $quocGia == 'Việt Nam' ? 'selected' : '' ?>>Việt Nam</option>
</select>

<!-- Tỉnh / Thành -->
<select name="tinh-thanh" onchange="this.form">
    <option value="">Chọn tỉnh / thành</option>
    <?php
    if ($quocGia && isset($dsTinhThanh[$quocGia])) {
        foreach ($dsTinhThanh[$quocGia] as $tinh) {
            $selected = $tinh == $tinhThanh ? 'selected' : '';
            echo "<option value=\"$tinh\" $selected>$tinh</option>";
        }
    }
    ?>
</select>

        <input type="text" name="so-nha-phuong-xa" value="<?= $soNhaPhuongXa ?>" placeholder="Số nhà, phường/xã">

        <button type="submit" class="submit-btn">Đăng Ký</button>
    </form>
</div>
</body>
</html>
