<?php
session_start();

// Kết nối CSDL
include '../db_connect.php'; 

// if(!isset($_SESSION['id'])){
//     header("Location:../index.php");
// }

$employer_id = $_SESSION['employer_id'];

$stmt1 = $conn->prepare("SELECT * FROM employers WHERE id = ?");
$stmt1->bind_param("i", $employer_id); // "i" là kiểu integer
$stmt1->execute();

$result1 = $stmt1->get_result();
$employer1 = $result1->fetch_assoc();

$logo_file1 = $employer1['logo'] ?? '';
if (!$logo_file1 || !file_exists('../img/logo/' . $logo_file1)) {
    $logo_file1 = '../logoweb.jpg'; // link ảnh mặc định
} else {
    $logo_file1 = '../img/logo/' . htmlspecialchars($logo_file1);
    
}

// Lấy ID công việc từ URL, nếu không có thì mặc định là 0
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn thông tin công việc
// Đã thêm JOIN employers trở lại để lấy logo và company_intro
$sql = "SELECT jobs.*, employers.logo, employers.company_intro, 
               COALESCE(jobs.company_name, employers.company_name) AS display_company_name
        FROM jobs
        JOIN employers ON jobs.employer_id = employers.id
        WHERE jobs.id = $job_id LIMIT 1";
$rs = mysqli_query($conn, $sql);
$job = mysqli_fetch_assoc($rs);

// Xử lý nếu không tìm thấy công việc
if (!$job) {
    echo "<!DOCTYPE html><html lang='vi'><head><meta charset='UTF-8'><title>Không tìm thấy</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head><body><div class='container mt-5'><div class='alert alert-danger'>Không tìm thấy công việc này hoặc công việc không tồn tại.</div><a href='../index.php' class='btn btn-primary'>Về trang chủ</a></div></body></html>";
    exit();
}

// Lấy các job tương tự theo ngành nghề (industry)
// Giữ nguyên truy vấn này vì nó chỉ cần thông tin từ bảng jobs
$sql_related = "SELECT jobs.*, 
                       COALESCE(jobs.company_name, employers.company_name) AS display_company_name
                FROM jobs
                JOIN employers ON jobs.employer_id = employers.id
                WHERE jobs.id != $job_id 
                AND jobs.industry = '".mysqli_real_escape_string($conn, $job['industry'])."' 
                ORDER BY jobs.created_at DESC LIMIT 4";
$rs_related = mysqli_query($conn, $sql_related);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($job['title']) ?? 'Chi tiết công việc' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .job-header { background: #fff; border-radius:14px; box-shadow:0 2px 8px #e9ecef; padding:32px 30px 18px 30px; margin-top:24px;}
        .job-header .job-logo { width:70px; height:70px; border-radius:10px; object-fit:contain; background:#fff; border:1px solid #e9ecef;}
        .job-title { font-size: 2rem; font-weight:700; color:#003366;}
        .company-name { font-size:1.2rem; }
        .job-info { color: #666; font-size: 1.05rem; }
        .job-meta .badge { font-size: 1rem; }
        .job-action .btn { min-width: 150px; font-weight: 600;}
        .nav-tabs .nav-link { color: #003366;}
        .nav-tabs .nav-link.active { color: #0056d2; font-weight: bold; border-bottom:2px solid #0056d2;}
        .tab-content { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 28px; margin-bottom: 36px;}
        .related-job { background:#fff; border-radius:10px; box-shadow:0 2px 8px #e9ecef; padding: 16px 10px; margin-bottom:16px;}
        .related-job .job-logo { width:38px; height:38px; border-radius:8px; object-fit:contain; margin-right: 10px;}
        .footer { background: #09223b; color: #fff; padding: 48px 0 24px 0;}
        .footer a { color: #fff; text-decoration: underline;}
        .footer .footer-col { margin-bottom: 24px;}
        .footer .footer-title { font-weight: 600; color: #ffb800;}
        .avatar-circle { width:38px; height:38px; border-radius:50%; background:#004b8d; color:#fff; font-weight:700; font-size:20px; display:flex; align-items:center; justify-content:center;}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
            <?php $logo_web = '../img/logo_CNTT_QNU.jpg'?>
            <img src= "<?= $logo_web?>" class="me-2" alt="Logo" style="height:34px;">
            Web Tìm Việc
        </a>
        <form class="d-none d-lg-flex ms-3 flex-grow-1" style="max-width: 440px;">
            <input type="text" class="form-control" placeholder="Nhập vị trí, từ khóa, công ty...">
            <button class="btn btn-primary ms-2" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar-circle me-2"><?= strtoupper(substr($_SESSION['user_name'] ?? 'UV',0,1)) ?></span>
                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'Ứng viên') ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="applicant_profile.php"><i class="bi bi-person-vcard me-2"></i> Hồ sơ xin việc</a></li>
                    <li><a class="dropdown-item" href="applicant_saved.php"><i class="bi bi-heart me-2"></i> Việc đã lưu</a></li>
                    <li><a class="dropdown-item" href="applicant_applied.php"><i class="bi bi-send me-2"></i> Việc đã ứng tuyển</a></li>
                    <li><a class="dropdown-item" href="applicant_notifications.php"><i class="bi bi-bell me-2"></i> Thông báo việc làm</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../index.php"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="job-header row">
        <div class="col-md-9 d-flex align-items-center">
            <img src="<?= $logo_file1 ?>" width="70" height="70" class="rounded-circle border" alt="<?= htmlspecialchars($job['company_name']) ?>" >
            <div>
                <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
                <div class="company-name mb-2"><b><?= htmlspecialchars($job['display_company_name']) ?></b></div>
                <div class="job-info mb-2">
                    <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($job['location']) ?> &nbsp;
                    <span class="badge bg-success"><?= htmlspecialchars($job['salary']) ?></span> &nbsp;
                    <span><i class="bi bi-briefcase"></i> 
                    <?php 
                    if (isset($job['years_experience'])) {
                        echo htmlspecialchars($job['years_experience'] == 0 ? 'Không yêu cầu kinh nghiệm' : $job['years_experience'] . ' năm kinh nghiệm');
                    } else {
                        echo 'N/A'; // Giá trị mặc định nếu cột không tồn tại
                    }
                    ?>
                    </span>
                </div>
                <div class="job-meta text-muted small mb-2">
                    <i class="bi bi-calendar"></i> Đăng ngày <?= date('H:i:s d/m/Y', strtotime($job['created_at'])) ?> &nbsp; 
                    <?php
                    $expiration_date = 'N/A';
                    if (isset($job['created_at']) && isset($job['display_duration'])) {
                        $created_timestamp = strtotime($job['created_at']);
                        $expiration_timestamp = strtotime("+" . $job['display_duration'] . " days", $created_timestamp);
                        $expiration_date = date('H:i:s d/m/Y', $expiration_timestamp);
                    }
                    ?>
                    | Hết hạn: <?= $expiration_date ?>
                </div>
                <div class="job-action mt-2">
                    <form method="post" action="applicant_apply.php">
                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                        <input type="hidden" name="job_employer_id" value="<?= $job['employer_id'] ?>">
                        <button type="submit" name="apply" class="btn btn-primary me-2">Nộp đơn ngay</button>
                    </form>
                    <a href="applicant_saved.php?job_id=<?= $job['id'] ?>" class="btn btn-outline-secondary">Lưu</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 d-none d-md-block">
            <div class="mb-2">
                <button class="btn btn-outline-primary w-100 mb-2"><i class="bi bi-bell"></i> Gửi thông báo cho tìm kiếm này</button>
            </div>
            <div class="fw-bold mb-2">Việc tương tự</div>
            <?php while($rjob = mysqli_fetch_assoc($rs_related)): ?>
                <div class="related-job d-flex align-items-center">
                    <?php if ($rjob['logo']): ?>
                        <img src="../upload/<?= htmlspecialchars($rjob['logo']) ?>" class="job-logo" alt="<?= htmlspecialchars($rjob['display_company_name']) ?>">
                    <?php else: ?>
                        <img src="../assets/logoweb.jpg" class="job-logo" alt="Logo">
                    <?php endif; ?>
                    <div>
                        <div class="fw-bold"><?= htmlspecialchars($rjob['title']) ?></div>
                        <div class="small text-muted"><?= htmlspecialchars($rjob['display_company_name']) ?></div>
                        <div class="small"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($rjob['location']) ?></div>
                        <div class="small text-primary"><?= htmlspecialchars($rjob['salary']) ?></div>
                        <a href="applicant_job_detail.php?id=<?= $rjob['id'] ?>" class="small d-inline-block">Xem ngay</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <ul class="nav nav-tabs mt-4" id="jobTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab">Mô tả</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="benefit-tab" data-bs-toggle="tab" data-bs-target="#benefit-tab-pane" type="button" role="tab">Quyền lợi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="skill-tab" data-bs-toggle="tab" data-bs-target="#skill-tab-pane" type="button" role="tab">Kỹ năng yêu cầu</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-tab-pane" type="button" role="tab">Chi tiết công việc</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab">Liên hệ</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company-tab-pane" type="button" role="tab">Về công ty</button>
        </li>
    </ul>
    <div class="tab-content mt-0" id="jobTabContent">
        <div class="tab-pane fade show active" id="desc-tab-pane" role="tabpanel">
            <?= nl2br(htmlspecialchars($job['description'] ?? '')) ?>
        </div>
        <div class="tab-pane fade" id="benefit-tab-pane" role="tabpanel">
            <?= nl2br(htmlspecialchars($job['benefit'] ?? '')) ?>
        </div>
        <div class="tab-pane fade" id="skill-tab-pane" role="tabpanel">
            <?= nl2br(htmlspecialchars($job['skill'] ?? '')) ?>
        </div>
        <div class="tab-pane fade" id="detail-tab-pane" role="tabpanel">
            <div class="row">
                <div class="col-md-6">
                    <div><b>Loại công việc:</b> <?= htmlspecialchars($job['job_type'] ?? '') ?></div>
                    <div><b>Cấp bậc:</b> <?= htmlspecialchars($job['level'] ?? '') ?></div>
                    <div><b>Học vấn:</b> <?= htmlspecialchars($job['education'] ?? '') ?></div>
                </div>
                <div class="col-md-6">
                    <div><b>Kinh nghiệm:</b> 
                    <?php 
                    if (isset($job['years_experience'])) {
                        echo htmlspecialchars($job['years_experience'] == 0 ? 'Không yêu cầu' : $job['years_experience'] . ' năm');
                    } else {
                        echo 'N/A';
                    }
                    ?>
                    </div>
                    <div><b>Giới tính:</b> <?= htmlspecialchars($job['gender'] ?? 'Nam / Nữ') ?></div>
                    <div><b>Ngành nghề:</b> <?= htmlspecialchars($job['industry'] ?? '') ?></div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel">
            <div><b>Địa chỉ:</b> <?= htmlspecialchars($job['contact_address'] ?? $job['location']) ?></div>
            <div><b>Email:</b> <?= htmlspecialchars($job['contact_email'] ?? '') ?></div>
            <div><b>Điện thoại:</b> <?= htmlspecialchars($job['contact_phone'] ?? '') ?></div>
        </div>
        <div class="tab-pane fade" id="company-tab-pane" role="tabpanel">
            <div><b>Tên công ty:</b> <?= htmlspecialchars($job['display_company_name'] ?? 'Đang cập nhật...') ?></div>
            <div><b>Giới thiệu công ty:</b></div>
            <div><?= nl2br(htmlspecialchars($job['company_intro'] ?? 'Đang cập nhật...')) ?></div> 
        </div>
    </div>
</div>
<div class="footer mt-5">
    <div class="container">
        <div class="row footer-col">
            <div class="col-md-3 footer-col">
                <div class="footer-title">Về Web Tìm Việc</div>
                <ul class="list-unstyled">
                    <li><a href="#">Về chúng tôi</a></li>
                    <li><a href="#">Quy chế hoạt động</a></li>
                    <li><a href="#">Quy định bảo mật</a></li>
                    <li><a href="#">Thỏa thuận sử dụng</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Dành cho ứng viên</div>
                <ul class="list-unstyled">
                    <li><a href="#">Việc làm</a></li>
                    <li><a href="#">Tìm việc làm nhanh</a></li>
                    <li><a href="#">Công ty</a></li>
                    <li><a href="#">Cẩm nang việc làm</a></li>
                    <li><a href="#">Mẫu CV Xin Việc</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Việc làm theo khu vực</div>
                <ul class="list-unstyled">
                    <li><a href="#">Hồ Chí Minh</a></li>
                    <li><a href="#">Hà Nội</a></li>
                    <li><a href="#">Đà Nẵng</a></li>
                    <li><a href="#">Hải Phòng</a></li>
                    <li><a href="#">Cần Thơ</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-col">
                <div class="footer-title">Kết nối với chúng tôi</div>
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