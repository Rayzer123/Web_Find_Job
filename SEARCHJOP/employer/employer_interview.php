<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header('Location: employer_login.php');
    exit;
}

// You can add database interaction here if you want to fetch any dynamic data
// (e.g., company-specific interview guidelines from the database)

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phỏng vấn nhiều vòng | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* --- CSS (You can move this to a separate file later) --- */
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

        .interview-section {
            margin-bottom: 25px;
        }

        .interview-section h3 {
            color: #004b8d;
            border-bottom: 2px solid #004b8d;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .interview-section ul,
        .interview-section ol {
            padding-left: 20px;
        }

        .tip-box {
            background-color: #f0f0f0;
            border-left: 5px solid #004b8d;
            padding: 10px;
            margin-bottom: 15px;
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
                    <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
                    <a class="nav-link" href="employer_alerts.php"><i class="bi bi-bell"></i> Quản lý tìm kiếm tài năng</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small">Blog</div>
                    <a class="nav-link" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển dụng</a>
                    <a class="nav-link active" href="employer_interview.php"><i class="bi bi-chat"></i> Phỏng vấn nhiều vòng...</a>
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

                <h2 class="dashboard-header">Phỏng vấn nhiều vòng</h2>

                <div class="dashboard-card">

                    <div class="interview-section">
                        <h3>Tại sao nên phỏng vấn nhiều vòng?</h3>
                        <p>Phỏng vấn nhiều vòng là một quy trình tuyển dụng trong đó ứng viên trải qua nhiều buổi phỏng vấn
                            khác nhau với các thành viên khác nhau trong công ty. Điều này giúp:</p>
                        <ul>
                            <li>Đánh giá ứng viên toàn diện hơn về kỹ năng, kinh nghiệm, và tính cách.</li>
                            <li>Giảm thiểu rủi ro tuyển dụng sai người.</li>
                            <li>Tăng cơ hội tìm được ứng viên phù hợp nhất với vị trí và văn hóa công ty.</li>
                        </ul>
                    </div>

                    <div class="interview-section">
                        <h3>Các vòng phỏng vấn phổ biến</h3>
                        <ol>
                            <li>
                                <h4>Vòng 1: Sàng lọc hồ sơ và phỏng vấn qua điện thoại</h4>
                                <p>Mục tiêu: Đánh giá nhanh chóng xem ứng viên có đáp ứng các yêu cầu cơ bản của vị trí không.</p>
                                <div class="tip-box">
                                    **Mẹo:** Chuẩn bị sẵn các câu hỏi sàng lọc ngắn gọn, tập trung vào kinh nghiệm và kỹ năng
                                    chính.
                                </div>
                            </li>
                            <li>
                                <h4>Vòng 2: Phỏng vấn trực tiếp với HR hoặc quản lý tuyển dụng</h4>
                                <p>Mục tiêu: Đánh giá chi tiết hơn về kỹ năng chuyên môn, kinh nghiệm làm việc, và động lực của
                                    ứng viên.</p>
                                <div class="tip-box">
                                    **Mẹo:** Sử dụng các câu hỏi tình huống và hành vi để hiểu rõ hơn về cách ứng viên xử lý các
                                    tình huống thực tế.
                                </div>
                            </li>
                            <li>
                                <h4>Vòng 3: Phỏng vấn với trưởng bộ phận hoặc các thành viên trong nhóm</h4>
                                <p>Mục tiêu: Đánh giá sự phù hợp của ứng viên với nhóm làm việc và văn hóa công ty.</p>
                                <div class="tip-box">
                                    **Mẹo:** Khuyến khích các thành viên trong nhóm tham gia vào quá trình phỏng vấn và đưa ra
                                    ý kiến.
                                </div>
                            </li>
                            <li>
                                <h4>Vòng 4 (Tùy chọn): Phỏng vấn với ban lãnh đạo hoặc làm bài kiểm tra</h4>
                                <p>Mục tiêu: Đánh giá các kỹ năng nâng cao (ví dụ: tư duy chiến lược, khả năng lãnh đạo) hoặc
                                    kiến thức chuyên môn sâu.</p>
                                <div class="tip-box">
                                    **Mẹo:** Thiết kế bài kiểm tra phù hợp với vị trí và đảm bảo tính công bằng.
                                </div>
                            </li>
                        </ol>
                    </div>

                    <div class="interview-section">
                        <h3>Lưu ý khi phỏng vấn nhiều vòng</h3>
                        <ul>
                            <li>**Giao tiếp rõ ràng:** Thông báo cho ứng viên về quy trình phỏng vấn, số lượng vòng, và thời
                                gian dự kiến.</li>
                            <li>**Phản hồi kịp thời:** Cung cấp phản hồi cho ứng viên sau mỗi vòng phỏng vấn, ngay cả khi họ
                                không được chọn.</li>
                            <li>**Đánh giá khách quan:** Đảm bảo quá trình đánh giá ứng viên công bằng và dựa trên các tiêu chí
                                đã được xác định trước.</li>
                            <li>**Sử dụng công cụ hỗ trợ:** Sử dụng phần mềm quản lý tuyển dụng để theo dõi và đánh giá ứng viên
                                trong suốt quá trình phỏng vấn.</li>
                        </ul>
                    </div>

                    </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>