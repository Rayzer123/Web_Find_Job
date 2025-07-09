<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header('Location: employer_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tài năng đã lưu | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* --- CSS (You can move this to a separate file) --- */
        body {
            background: #f6f8fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #e6e9ef;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:focus {
            background: #e3f1ff;
            color: #004b8d !important;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #333;
        }

        .sidebar .nav-link i {
            width: 20px;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 0;
            width: 220px;
            padding: 12px;
            font-size: 14px;
            color: #888;
        }

        .main-content {
            background: #f6f8fa;
            min-height: 100vh;
        }

        .dashboard-header {
            color: #004b8d;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px #aaa3;
            margin-bottom: 20px;
        }

        .candidate-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .candidate-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .candidate-info {
            margin-bottom: 8px;
        }

        .unsave-button {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .unsave-button:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-2 sidebar px-0 d-flex flex-column position-relative">
                <div class="pt-4 ps-3 mb-2">
               <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                    <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" class="me-2" alt="Logo" width="60" height="60"> Web Tìm Việc
                </a>
            </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="employer_dashboard.php"><i class="bi bi-person"></i> My Web</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small">Công Việc</div>
                    <a class="nav-link" href="employer_jobs.php"><i class="bi bi-briefcase"></i> Công việc của tôi</a>
                    <a class="nav-link" href="employer_post_job.php"><i class="bi bi-plus-square"></i> Đăng Tuyển dụng</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small">Ứng viên của tôi</div>
                    <a class="nav-link" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                    <a class="nav-link active" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                    <a class="nav-link" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small">Blog</div>
                    <a class="nav-link" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển dụng</a>
                    <a class="nav-link" href="employer_interview.php"><i class="bi bi-chat"></i> Phỏng vấn nhiều vòng...</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small"> </div>
                    <a class="nav-link" href="employer_help.php"><i class="bi bi-question-circle"></i> Hỗ trợ</a>
                    <a class="nav-link" href="employer_organization.php"><i class="bi bi-people"></i> Tổ chức</a>
                    <a class="nav-link" href="employer_settings.php"><i class="bi bi-gear"></i> Cài đặt</a>
                </nav>
                <div class="sidebar-bottom">
                    <div><b><?= htmlspecialchars($_SESSION['employer_name']) ?></b></div>
                    <div style="font-size:13px;"><?= htmlspecialchars($_SESSION['employer_email'] ?? '') ?></div>
                </div>
            </div>

            <div class="col-10 main-content px-5 py-4">

                <h2 class="dashboard-header">Tài năng đã lưu</h2>

                <?php if (isset($message)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <div class="dashboard-card">
                    <?php if (empty($saved_candidates)): ?>
                        <p>Bạn chưa lưu ứng viên nào.</p>
                    <?php else: ?>
                        <?php foreach ($saved_candidates as $candidate): ?>
                            <div class="candidate-card">
                                <h5 class="candidate-name"><?= htmlspecialchars($candidate['name']) ?></h5>
                                <p class="candidate-info">Email: <?= htmlspecialchars($candidate['email']) ?></p>
                                <p class="candidate-info">Kỹ năng: <?= htmlspecialchars($candidate['skills']) ?></p>
                                <a href="candidate_profile.php?id=<?= $candidate['id'] ?>">Xem hồ sơ</a> |
                                <form method="post" action="employer_saved.php" style="display:inline-block;">
                                    <input type="hidden" name="candidate_id" value="<?= $candidate['id'] ?>">
                                    <button type="submit" name="unsave_candidate" class="unsave-button">Bỏ lưu</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>