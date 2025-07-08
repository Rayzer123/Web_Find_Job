<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm tài năng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .sidebar {
            width: 250px;
            background: #fff;
            min-height: 100vh;
            border-right: 1px solid #e5eaf0;
            padding: 0;
            position: fixed;
            top: 0; left: 0;
        }
        .sidebar .logo {
            text-align: center;
            padding: 24px 0 8px 0;
           
        }
        .sidebar .menu {
            margin-top: 16px;
        }
        .sidebar .menu li {
            list-style: none;
            margin-bottom: 8px;
        }
        .sidebar .menu .active {
            background: #e5f0ff;
            border-radius: 6px;
        }
        .sidebar .menu a {
            display: block;
            color: #222;
            text-decoration: none;
            padding: 12px 24px;
            font-weight: 500;
        }
        .sidebar .menu a:hover, .sidebar .menu .active a {
            color: #1976d2;
        }
        .sidebar .blog, .sidebar .support, .sidebar .bottom-user {
            margin: 32px 0 0 0;
            padding-left: 24px;
            font-size: 15px;
        }
        .sidebar .bottom-user {
            position: absolute;
            bottom: 24px; left: 24px;
        }
        .main-content {
            margin-left: 250px;
            padding: 32px 40px 0 40px;
        }
        .search-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }
        .search-header .search-group {
            flex: 1;
            display: flex;
            gap: 12px;
        }
        .search-header input[type="text"] {
            min-width: 260px;
        }
        .search-filters {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px #aaa3;
            padding: 70px 20px 80px 24px;
            margin-bottom: 24px;
            display: flex;
            gap: 32px;
            display: flex;
            flex-wrap: wrap;
        }
        .search-filters .filter-group {
            min-width: 220px;
            margin-right: 12px;
        }
        .search-filters label {
            font-weight: 500;
            margin-bottom: 4px;
        }
        .search-filters .form-select, 
        .search-filters .form-control {
            margin-bottom: 10px;
        }
        .search-filters .form-range {
            margin-top: 10px;
        }
        .search-filters .btn-group .btn {
            margin-right: 4px;
        }
        .talent-illustration {
            text-align: center;
            margin: 40px 0 20px 0;
        }
        .talent-illustration img {
            max-width: 320px;
        }
        .talent-desc {
            color: #1976d2;
            margin-top: 12px;
            font-size: 17px;
            font-weight: 500;
        }
        .talent-note {
            color: #444;
            margin-top: 18px;
        }
        @media (max-width: 900px) {
            .sidebar { width: 100px; }
            .main-content { margin-left: 100px; padding: 24px 6px 0 6px;}
            .search-filters { flex-wrap: wrap; gap: 16px;}
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" width="60px"  border-radius="10px"; alt="ưeblogo">
    </div>
    <ul class="menu">
        <li><a href="employer_jobs">Công việc của tôi</a></li>
        <li><a href="employer_post_job.php">Đăng Tuyển dụng</a></li>
        <li class="active"><a href="#">Tìm kiếm tài năng</a></li>
        <a href="employer_applicants.php">Thư xin việc đã nhận</a>
        <li><a href="employer_saved.php">Tài năng đã lưu</a></li>
        <li><a href="employer_alerts.php">Quản lý tìm kiếm tài năng</a></li>
    </ul>
    <div class="blog">
        <div><b>Blog</b></div>
        <div><a href="employer_handbook.php" style="color:#1976d2;text-decoration:none;">Cẩm nang Tuyển dụng</a></div>
        <div><a href="employer_interview.php" style="color:#1976d2;text-decoration:none;">Phỏng vấn nhiều vòng...</a></div>
    </div>
    <div class="support">
        <div><a href="employer_help.php" style="color:#1976d2;text-decoration:none;">Hỗ trợ</a></div>
        <div><a href="employer_organization.php" style="color:#1976d2;text-decoration:none;">Tổ chức</a></div>
        <div><a href="employer_settings.php" style="color:#1976d2;text-decoration:none;">Cài đặt</a></div>
    </div>
    <div class="bottom-user">
        <span style="color: #1976d2;">vô danh</span>
        <div style="font-size:13px; color:#888;">nguyenxuanquy2005thd@gmail.com</div>
    </div>
</div>
<div class="main-content">
    <div class="search-header">
        <div class="search-group">
            <input type="text" class="form-control" placeholder="Nhập từ khoá">
            <input type="text" class="form-control" placeholder="Nhập tỉnh, thành phố">
        </div>
        <button class="btn btn-primary">Tìm kiếm</button>
    </div>
    <div style="margin-bottom:12px;">
        <label style="margin-right:16px;">Tìm kiếm theo:</label>
        <input type="radio" checked> Tất cả
        <input type="radio" style="margin-left:24px;"> Tiêu đề hồ sơ
        <a href="#" class="btn btn-link btn-sm" style="float:right;">Xem tất cả các tìm kiếm</a>
    </div>
    <div class="search-filters">
        <div class="filter-group">
            <label>Công việc đang tuyển</label>
            <select class="form-select"><option>Công việc đang tuyển</option></select>
        </div>
        <div class="filter-group">
            <label>Ngành nghề</label>
            <select class="form-select"><option>Ngành nghề</option></select>
        </div>
        <div class="filter-group">
            <label>Kinh nghiệm làm việc</label>
            <select class="form-select"><option>Kinh nghiệm làm việc</option></select>
        </div>
        <div class="filter-group">
            <label>Cấp bậc</label>
            <select class="form-select"><option>Cấp bậc</option></select>
        </div>
        <div class="filter-group">
            <label>Mức lương</label>
            <select class="form-select"><option>Mức lương</option></select>
        </div>
        <div class="filter-group">
            <label>Loại công việc</label>
            <select class="form-select"><option>Loại công việc</option></select>
        </div>
        <div class="filter-group">
            <label>Trình độ học vấn</label>
            <select class="form-select"><option>Học vấn</option></select>
        </div>
        <div class="filter-group">
            <label>Trường</label>
            <input type="text" class="form-control" placeholder="Nhập tên trường">
        </div>
        <div class="filter-group">
            <label>Chuyên môn</label>
            <input type="text" class="form-control" placeholder="Chuyên môn">
        </div>
        <div class="filter-group">
            <label>Trình độ ngoại ngữ</label>
            <select class="form-select"><option>Ngôn ngữ</option></select>
        </div>
        <div class="filter-group">
            <label>Giới tính</label>
            <div class="btn-group" role="group">
                <button class="btn btn-outline-secondary btn-sm active">Bất kỳ</button>
                <button class="btn btn-outline-secondary btn-sm">Nam</button>
                <button class="btn btn-outline-secondary btn-sm">Nữ</button>
            </div>
        </div>
        <div class="filter-group">
            <label>Tình trạng hôn nhân</label>
            <div class="btn-group" role="group">
                <button class="btn btn-outline-secondary btn-sm active">Bất kỳ</button>
                <button class="btn btn-outline-secondary btn-sm">Độc thân</button>
                <button class="btn btn-outline-secondary btn-sm">Đã kết hôn</button>
            </div>
        </div>
        <div class="filter-group">
            <label>Độ tuổi</label>
            <input type="range" class="form-range" min="15" max="70" value="15" style="width:140px;">
        </div>
        <div class="filter-group">
            <label>Hồ sơ đăng trong vòng</label>
            <select class="form-select"><option>Thời gian đăng hồ sơ</option></select>
        </div>
    </div>
    <div class="talent-illustration">
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="Tìm kiếm hồ sơ" style="margin-bottom:8px;">
        <div class="talent-desc">Đề xuất hồ sơ • Tìm CV ứng viên • Quản lý hồ sơ</div>
        <div class="talent-note">
            Khám phá hàng ngàn CV chất lượng cao với công cụ tìm kiếm thông minh của chúng tôi. Bắt đầu ngay bằng cách nhập từ khóa vào thanh tìm kiếm hoặc sử dụng bộ lọc chi tiết để tìm ứng viên phù hợp nhất.
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>