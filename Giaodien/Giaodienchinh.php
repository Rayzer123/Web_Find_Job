<?php
$dsTinhThanh = ["Quy Nhơn", "Gia Lai", "Hà Nội", "TP. Hồ Chí Minh", "Đà Nẵng"];
$tukhoa = isset($_POST['search']) ? trim($_POST['search']) : "";
?>
<html>
<head>
  <title>Tìm Việc Làm</title>
  <link rel="stylesheet" href="Gdc.css">
</head>
<body>
  <form method="POST">
    <header class="navbar">
      <img src="../img/logo_CNTT_QNU.jpg" alt="CareerLink Logo" class="logo">
      <input type="text" name="search" placeholder="Nhập tỉnh, thành phố" class="search-box"
             value="<?php echo htmlspecialchars($tukhoa); ?>">
      <button type="submit" class="search-btn">Tìm kiếm</button>
      <a class="Dnh" href="GiaodiendangNhap.php">Đăng Nhập</a>
    </header>
    <div id="menu">
      <ul>
        <li>Nghe nghiep</li>
        <ul>
          <li><input type="checkbox" name="nn" value="DEV">Dev</li>
          <li><input type="checkbox" name="nn" value="DEV">Dev</li>
          <li><input type="checkbox" name="nn" value="DEV">Dev</li>
          <li><input type="checkbox" name="nn" value="DEV">Dev</li>
        </ul>
      </ul>
    </div>
  </form>
</body>
</html>
