<?php
include '../db_connect.php';
session_start();

$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$location = isset($_GET['location']) ? trim($_GET['location']) : '';

// Chuẩn bị truy vấn SQL với escape để tránh lỗi và bảo mật
$sql = "SELECT jobs.*, employers.company_name, employers.logo 
        FROM jobs 
        JOIN employers ON jobs.employer_id = employers.id 
        WHERE 1 ";

if ($keyword) {
    $keyword_sql = mysqli_real_escape_string($conn, $keyword);
    $sql .= "AND (jobs.title LIKE '%$keyword_sql%' OR jobs.description LIKE '%$keyword_sql%') ";
}
if ($location) {
    $location_sql = mysqli_real_escape_string($conn, $location);
    $sql .= "AND (jobs.location LIKE '%$location_sql%' OR employers.company_name LIKE '%$location_sql%') ";
}
$sql .= "ORDER BY jobs.created_at DESC";

// Thực hiện truy vấn, kiểm tra lỗi
$rs = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm việc làm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .search-bar { background: #eaf4fd; padding: 30px 0 12px 0; }
        .section-title { color: #004b8d; font-weight: 700; margin-bottom: 16px; }
        .job-card { border-radius: 12px; box-shadow: 0 2px 8px #e9ecef; background:#fff; margin-bottom:22px; transition:0.2s;}
        .job-card:hover { box-shadow: 0 6px 24px #aacbee66; border: 1.5px solid #188cff; }
        .job-logo { width:56px;height:56px;object-fit:contain;border-radius:8px;background:#fff;border:1px solid #e9ecef;}
        .job-title { font-size:1.1rem;font-weight:600; }
        .company-name { color:#555; }
        .salary { font-weight:bold; color: #0d6efd;}
        .footer { background: #09223b; color: #fff; padding: 48px 0 24px 0;}
        .footer a { color: #fff; text-decoration: underline;}
        .footer-title { font-weight: 600; color: #ffb800;}
    </style>
</head>
<body>
<div class="search-bar">
    <div class="container">
        <form class="row g-2" method="get" action="applicant_jobs.php">
            <div class="col-12 col-md-5">
                <input type="text" class="form-control" name="search" placeholder="Nhập từ khóa (VD: Kế toán, IT...)" value="<?= htmlspecialchars($keyword) ?>">
            </div>
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" name="location" placeholder="Địa điểm (VD: TP.HCM, Hà Nội...)" value="<?= htmlspecialchars($location) ?>">
            </div>
            <div class="col-12 col-md-3 d-grid">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search me-1"></i> Tìm kiếm</button>
            </div>
        </form>
    </div>
</div>
<div class="container mt-4">
    <div class="section-title">
        Kết quả tìm kiếm việc làm
        <?= $keyword ? 'cho "<b>'.htmlspecialchars($keyword).'</b>"' : '' ?>
        <?= $location ? 'tại <b>'.htmlspecialchars($location).'</b>' : '' ?>
    </div>
    <?php if($rs === false): ?>
        <div class="alert alert-danger">
            Có lỗi truy vấn cơ sở dữ liệu!<br>
            <b><?= mysqli_error($conn) ?></b>
        </div>
    <?php elseif(mysqli_num_rows($rs) == 0): ?>
        <div class="alert alert-warning">Không tìm thấy công việc phù hợp!</div>
    <?php else: ?>
        <?php while($job = mysqli_fetch_assoc($rs)): ?>
            <div class="job-card p-3 d-flex align-items-center">
                <?php if ($job['logo']): ?>
                    <img src="../upload/<?= htmlspecialchars($job['logo']) ?>" class="job-logo me-3" alt="<?= htmlspecialchars($job['company_name']) ?>">
                <?php else: ?>
                    <img src="../assets/logoweb.jpg" class="job-logo me-3" alt="Logo">
                <?php endif; ?>
                <div class="flex-grow-1">
                    <div class="job-title">
                        <a href="applicant_job_detail.php?id=<?= $job['id'] ?>"
                           class="text-decoration-none text-dark"><?= htmlspecialchars($job['title']) ?></a>
                    </div>
                    <div class="company-name"><?= htmlspecialchars($job['company_name']) ?> • <?= htmlspecialchars($job['location']) ?></div>
                    <div class="salary"><?= htmlspecialchars($job['salary']) ?></div>
                    <div class="small text-muted">Cập nhật: <?= date('d/m/Y', strtotime($job['created_at'])) ?></div>
                </div>
                <div>
                    <a href="applicant_job_detail.php?id=<?= $job['id'] ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
<!-- Footer -->
<div class="footer mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3"><div class="footer-title">Về Web Tìm Việc</div>
                <ul class="list-unstyled">
                    <li><a href="#">Về chúng tôi</a></li>
                    <li><a href="#">Quy chế hoạt động</a></li>
                    <li><a href="#">Quy định bảo mật</a></li>
                    <li><a href="#">Thỏa thuận sử dụng</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-3"><div class="footer-title">Dành cho ứng viên</div>
                <ul class="list-unstyled">
                    <li><a href="#">Việc làm</a></li>
                    <li><a href="#">Tìm việc làm nhanh</a></li>
                    <li><a href="#">Công ty</a></li>
                    <li><a href="#">Cẩm nang việc làm</a></li>
                    <li><a href="#">Mẫu CV Xin Việc</a></li>
                </ul>
            </div>
            <div class="col-md-3"><div class="footer-title">Việc làm theo khu vực</div>
                <ul class="list-unstyled">
                    <li><a href="#">Hồ Chí Minh</a></li>
                    <li><a href="#">Hà Nội</a></li>
                    <li><a href="#">Đà Nẵng</a></li>
                    <li><a href="#">Hải Phòng</a></li>
                    <li><a href="#">Cần Thơ</a></li>
                </ul>
            </div>
            <div class="col-md-3"><div class="footer-title">Kết nối với chúng tôi</div>
                <div class="mb-2">
                    <img src="../assets/logoweb.jpg" height="32" alt="">
                </div>
                <div>
                    <a href="#"><i class="bi bi-facebook me-1"></i></a>
                    <a href="#"><i class="bi bi-youtube me-1"></i></a>
                    <a href="#"><i class="bi bi-linkedin me-1"></i></a>
                    <a href="#"><i class="bi bi-tiktok"></i></a>
                </div>
                <div class="mt-2 small">Tải ứng dụng:
                    <img src="https://careerlink.vn/static/img/app-googleplay.png" height="28" alt="play">
                    <img src="https://careerlink.vn/static/img/app-appstore.png" height="28" alt="appstore">
                </div>
            </div>
        </div>
        <div class="text-center mt-3 small">© <?= date("Y") ?> Web Tìm Việc. Thiết kế bởi Quytop1.</div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>