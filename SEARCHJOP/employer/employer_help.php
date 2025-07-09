<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header('Location: employer_login.php');
    exit; // Important to stop further execution
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hỗ trợ | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* --- CSS (You can extract this to a separate file later) --- */
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

        .faq-question {
            font-weight: bold;
            margin-bottom: 5px;
            cursor: pointer;
        }

        .faq-answer {
            padding: 10px;
            border-left: 3px solid #004b8d;
            margin-bottom: 15px;
            display: none;
        }

        .contact-info {
            list-style-type: none;
            padding-left: 0;
        }

        .contact-info li {
            margin-bottom: 8px;
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
                    <a class="nav-link" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang Tuyển
                        dụng</a>
                    <a class="nav-link" href="employer_interview_tips.php"><i class="bi bi-chat"></i> Phỏng vấn nhiều
                        vòng...</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small"> </div>
                    <a class="nav-link active" href="employer_help.php"><i class="bi bi-question-circle"></i> Hỗ trợ</a>
                    <a class="nav-link" href="employer_organization.php"><i class="bi bi-people"></i> Tổ chức</a>
                    <a class="nav-link" href="employer_settings.php"><i class="bi bi-gear"></i> Cài đặt</a>
                </nav>
                <div class="sidebar-bottom">
                    <div><b><?= htmlspecialchars($_SESSION['employer_name']) ?></b></div>
                    <div style="font-size:13px;"><?= htmlspecialchars($_SESSION['employer_email'] ?? '') ?></div>
                </div>
            </div>

            <div class="col-10 main-content px-5 py-4">

                <h2 class="dashboard-header">Trung tâm Hỗ trợ</h2>

                <div class="dashboard-card">
                    <h3>Các câu hỏi thường gặp (FAQ)</h3>

                    <div class="faq-section">
                        <div class="faq-question" onclick="toggleAnswer('faq1')">
                            <i class="bi bi-question-circle"></i> Làm thế nào để đăng tin tuyển dụng?
                        </div>
                        <div class="faq-answer" id="faq1">
                            Để đăng tin tuyển dụng, bạn cần truy cập vào trang "Đăng Tuyển dụng" từ menu bên trái. Điền đầy
                            đủ thông tin về vị trí cần tuyển và nhấn nút "Đăng tin".
                        </div>
                    </div>

                    <div class="faq-section">
                        <div class="faq-question" onclick="toggleAnswer('faq2')">
                            <i class="bi bi-question-circle"></i> Làm sao để xem các ứng viên đã nộp hồ sơ?
                        </div>
                        <div class="faq-answer" id="faq2">
                            Bạn có thể xem danh sách ứng viên bằng cách vào trang "Thư xin việc đã nhận". Tại đây, bạn sẽ
                            thấy danh sách các ứng viên và có thể xem chi tiết hồ sơ của từng người.
                        </div>
                    </div>

                    <div class="faq-section">
                        <div class="faq-question" onclick="toggleAnswer('faq3')">
                            <i class="bi bi-question-circle"></i> Tôi có thể chỉnh sửa thông tin công ty ở đâu?
                        </div>
                        <div class="faq-answer" id="faq3">
                            Bạn có thể chỉnh sửa thông tin công ty ở trang "Tổ chức". Tại đây, bạn có thể cập nhật tên công
                            ty, mô tả, địa chỉ và các thông tin liên quan khác.
                        </div>
                    </div>

                    <div class="faq-section">
                        <div class="faq-question" onclick="toggleAnswer('faq4')">
                            <i class="bi bi-question-circle"></i> Làm thế nào để tìm kiếm ứng viên tiềm năng?
                        </div>
                        <div class="faq-answer" id="faq4">
                            Bạn có thể sử dụng chức năng "Tìm kiếm tài năng" để tìm kiếm ứng viên theo kỹ năng, kinh nghiệm
                            và các tiêu chí khác.
                        </div>
                    </div>

                    <div class="faq-section">
                        <div class="faq-question" onclick="toggleAnswer('faq5')">
                            <i class="bi bi-question-circle"></i> Làm cách nào để lưu lại hồ sơ ứng viên?
                        </div>
                        <div class="faq-answer" id="faq5">
                            Bạn có thể lưu lại hồ sơ ứng viên bằng cách nhấn vào biểu tượng "bookmark" trên hồ sơ của ứng
                            viên. Các hồ sơ đã lưu sẽ được hiển thị ở trang "Tài năng đã lưu".
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <h3>Liên hệ hỗ trợ</h3>
                    <p>Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ thêm, xin vui lòng liên hệ với chúng tôi theo các kênh sau:</p>
                    <ul class="contact-info">
                        <li><i class="bi bi-envelope"></i> Email: <a
                                href="mailto:hotro@webtimviec.com">hotro@webtimviec.com</a></li>
                        <li><i class="bi bi-phone"></i> Điện thoại: 1900 123 456</li>
                        <li><i class="bi bi-clock"></i> Thời gian làm việc: Thứ 2 - Thứ 6 (8:00 - 17:00)</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleAnswer(id) {
            var answer = document.getElementById(id);
            if (answer.style.display === "none") {
                answer.style.display = "block";
            } else {
                answer.style.display = "none";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>