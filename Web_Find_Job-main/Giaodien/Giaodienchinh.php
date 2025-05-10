<?php
$dsTinhThanh = ["Quy Nhơn", "Gia Lai", "Hà Nội", "TP. Hồ Chí Minh", "Đà Nẵng"];
$tukhoa = isset($_POST['search']) ? trim($_POST['search']) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tìm việc làm</title>
  <link rel="stylesheet" href="Gdc.css?v=<?= filemtime('Gdc.css') ?>">
</head>
<body>
  <div class="hinhnen"></div>
  <form method="POST">
    <header class="navbar">
      <img src="../img/logo_CNTT_QNU.jpg" alt="CareerLink Logo" class="logo">
      <input type="text" name="search" placeholder="Nhập tỉnh, thành phố" class="search-box"
             value="<?php echo htmlspecialchars($tukhoa); ?>">
      <input type="text" name="search1" placeholder="Nhập tên công việc" class="search-box" >
      <button type="submit" class="search-btn">Tìm kiếm</button>
      <a class="Dnh" href="GiaodiendangNhap.php">Đăng Nhập</a>
    </header>
  </form>
  
  <div class="infor3381">
    <h1 id="h14928">NƠI TÌM VIỆC LÀM DỄ DÀNG</h1>
  </div>
  
</body>
</html>
