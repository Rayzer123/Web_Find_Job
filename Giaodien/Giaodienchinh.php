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
  <div class= "phankhung">
			<div class="firstcol1">
					<div style="font-size:23px;"><h6><b>Về Career Link</b></h6></div><br>
					<li><a href = ""><div style="color:white;">Về Chúng Tôi</div></a></li><br>
					<li><a href =""><div style="color:white;">Quy Chế Hoạt Động</div></a><br>
					<li><a href =""><div style="color:white;">Quy Định Bảo Mật</div></a></li><br>
					<li><a href =""><div style="color:white;">Thỏa Thuận Sử Dụng</div></a></li><br>
					<li><a href =""><div style="color:white;">Liên Hệ</div></a></li><br>
					<li><a href =""><div style="color:white;">Sơ Đồ Trang Web</div></a></li><br>
					<li><a href =""><div style="color:white;">Career Link.asia</div></a></li><br>
			</div>
			<div class="secondcol2">
					<div style="font-size:23px;"><h6><b>Dành Cho Ứng Viên</b></h6></div><br>
					<li><a href=""><div style="color:white;">Việc Làm</div></a></li><br>
					<li><a href=""><div style="color:white;">Tìm Việc Làm Nhanh</div></a></li><br>
					<li><a href=""><div style="color:white;">Công Ty</div></a></li><br>
					<li><a href=""><div style="color:white;">Cẩm Nang Việc Làm</div></a></li><br>
					<li><a href=""><div style="color:white;">Mẫu CV Xin Việc</div></a></li><br>
					<li><a href=""><div style="color:white;">Tư Vấn Du Học Nhật Bản</div></a></li><br>
					<div style="height:10px;"></div><div style="padding-top:5px;">
							<div style="font-size:23px;"><h6><b>Dành Cho Nhà Tuyển Dụng</b></h6></div><br>
							<li><a href=""><div style="color:white;">Dịch Vụ Nhân Sự Cao Cấp</div></a></li><br>
							<li><a href=""><div style="color:white;">Cẩm Nang Tuyển Dụng</div></a></li><br>
					</div>
			</div>
			<div class="thirtcol3">
					<div style="font-size:23px;"><h6><b>Việc Làm Theo Khu Vực</b></h6></div><br>
					<li><a href =""><div style="color:white;">Quy Nhơn</div></a></li><br>
					<li><a href =""><div style="color:white;">Gia Lai</div></a></li><br>
					<li><a href=""><div style="color:white;">Hà Nội</div></a></li><br>
					<li><a href=""><div style="color:white;">Hồ Chí Minh</div></a></li><br>
					<li><a href=""><div style="color:white;">Đà Nẵng</div></a></li><br>
					<div style= "height:10px;"></div><div style="padding-top:5px;">
							<div style="font-size:23px;"><h6><b>Làm Việc Theo Ngành Nghề</h6></b></div><br>
							<li><a href=""><div style="color:white;">Kế Toán</div></a></li><br>
							<li><a href=""><div style="color:white;">Tiếng Nhật</div></a></li><br>
							<li><a href=""><div style="color:white;">Ngân Hàng</div></a></li><br>
							<li><a href=""><div style="color:white;">IT-Phần Mềm</div></a></li><br>
							<li><a href=""><div style="color:white;">IT-Phần Cứng/Mạng</div></a></li><br>
					</div>
			</div>
			<div class="lastcol4">
					<div style="font-size:23px;"><h6><b>Kết Nối Với</b></h6></div><br>
					<div style="display:flex;">
						<li><a  href="https://www.facebook.com/groups/timvieclamonlinecntt46a"><img style ="width:30px; height: 30px;margin-right: 15px;" src="https://i.pinimg.com/736x/0f/ca/71/0fca71d455309dcdfa7e173b6ea0dc0b.jpg" alt="Logo Facebook"  /></a></li>
						<a><img style = " width: 30px; height: 30px;margin-right: 15px;" src="https://i.pinimg.com/736x/07/d4/34/07d434c06fe0f9cb77c4c773886705a7.jpg" alt="logo ins"/></a>
						<li><a  href="https://www.tiktok.com/@timvieclam_46a"><img style = " width: 30px; height: 30px;" src="https://i.pinimg.com/736x/f0/13/54/f0135427ced1d0ee804a3191f87b5a11.jpg" alt="logo tiktok" /></a></li>
					</div>
			</div>
  </div>
</body>
</html>
