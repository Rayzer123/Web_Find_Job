<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header('Location: employer_login.php');
    exit;
}

// You can fetch additional data if needed (e.g., company info)
// Example:
// $employer_id = $_SESSION['employer_id'];
// $query = "SELECT company_name FROM employers WHERE id = $employer_id";
// $result = mysqli_query($connection, $query);
// $company_data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cẩm nang Tuyển dụng | Web Tìm Việc</title>
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

        .handbook-section {
            margin-bottom: 25px;
        }

        .handbook-section h3 {
            color: #004b8d;
            border-bottom: 2px solid #004b8d;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .handbook-section ul,
        .handbook-section ol {
            padding-left: 20px;
        }

        .handbook-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .handbook-section th,
        .handbook-section td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .handbook-section th {
            background-color: #f0f0f0;
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
                    <a class="nav-link active" href="employer_handbook.php"><i class="bi bi-journal-richtext"></i> Cẩm nang
                        Tuyển dụng</a>
                    <a class="nav-link" href="employer_interview.php"><i class="bi bi-chat"></i> Phỏng vấn nhiều
                        vòng...</a>
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

                <h2 class="dashboard-header">Cẩm nang Tuyển dụng</h2>

                <div class="dashboard-card">

                    <div class="handbook-section">
                        <h3>Tổng quan về quy trình tuyển dụng</h3>
                        <p>Tuyển dụng là quá trình tìm kiếm, lựa chọn và thu hút nhân tài phù hợp với nhu cầu của tổ chức.
                            Một quy trình tuyển dụng hiệu quả giúp đảm bảo rằng công ty có được những nhân viên chất lượng,
                            góp phần vào sự phát triển bền vững.</p>
                        <p>Các bước chính trong quy trình tuyển dụng bao gồm:</p>
                        <ol>
                            <li>Xác định nhu cầu tuyển dụng</li>
                            <li>Soạn thảo và đăng tin tuyển dụng</li>
                            <li>Thu thập và sàng lọc hồ sơ ứng viên</li>
                            <li>Phỏng vấn ứng viên</li>
                            <li>Đánh giá và lựa chọn ứng viên</li>
                            <li>Đề nghị tuyển dụng và hội nhập nhân viên mới</li>
                        </ol>
                    </div>

                    <div class="handbook-section">
                        <h3>1. Xác định nhu cầu tuyển dụng</h3>
                        <p>Bước đầu tiên và quan trọng nhất là xác định rõ ràng nhu cầu tuyển dụng. Điều này bao gồm:</p>
                        <ul>
                            <li>**Phân tích công việc:** Xác định các nhiệm vụ, trách nhiệm và kỹ năng cần thiết cho vị trí.</li>
                            <li>**Xác định số lượng và trình độ:** Quyết định có bao nhiêu người cần tuyển và trình độ chuyên môn
                                mong muốn.</li>
                            <li>**Lập kế hoạch thời gian:** Đặt ra khung thời gian cho toàn bộ quá trình tuyển dụng.</li>
                        </ul>
                        <p>Việc xác định rõ nhu cầu giúp bạn tập trung vào việc tìm kiếm ứng viên phù hợp và tiết kiệm thời
                            gian, chi phí.</p>
                    </div>

                    <div class="handbook-section">
                        <h3>2. Soạn thảo và đăng tin tuyển dụng</h3>
                        <p>Tin tuyển dụng là "bộ mặt" của công ty trong quá trình tuyển dụng. Một tin tuyển dụng hấp dẫn và
                            chính xác sẽ thu hút được nhiều ứng viên tiềm năng.</p>
                        <h4>Các yếu tố quan trọng của tin tuyển dụng:</h4>
                        <ul>
                            <li>**Tiêu đề:** Ngắn gọn, rõ ràng, thu hút sự chú ý.</li>
                            <li>**Mô tả công việc:** Chi tiết, dễ hiểu, nêu rõ trách nhiệm và quyền lợi.</li>
                            <li>**Yêu cầu ứng viên:** Cụ thể về kỹ năng, kinh nghiệm, trình độ học vấn.</li>
                            <li>**Thông tin công ty:** Giới thiệu về công ty, văn hóa, cơ hội phát triển.</li>
                            <li>**Cách thức ứng tuyển:** Hướng dẫn rõ ràng về cách nộp hồ sơ.</li>
                        </ul>
                        <p>Đăng tin tuyển dụng trên các kênh phù hợp (website tuyển dụng, mạng xã hội, v.v.) để tiếp cận
                            được nhiều ứng viên.</p>
                    </div>

                    <div class="handbook-section">
                        <h3>3. Thu thập và sàng lọc hồ sơ ứng viên</h3>
                        <p>Sau khi đăng tin, bạn sẽ nhận được nhiều hồ sơ ứng tuyển. Bước tiếp theo là sàng lọc hồ sơ để
                            chọn ra những ứng viên tiềm năng nhất.</p>
                        <h4>Mẹo sàng lọc hồ sơ hiệu quả:</h4>
                        <ul>
                            <li>**Xác định tiêu chí sàng lọc:** Dựa trên yêu cầu công việc, xác định các tiêu chí quan trọng
                                (kỹ năng, kinh nghiệm, v.v.).</li>
                            <li>**Đánh giá khách quan:** Đánh giá hồ sơ dựa trên tiêu chí đã đặt ra, tránh thiên vị.</li>
                            <li>**Sử dụng công cụ hỗ trợ:** Nếu số lượng hồ sơ lớn, có thể sử dụng phần mềm quản lý tuyển dụng.</li>
                        </ul>
                    </div>

                    <div class="handbook-section">
                        <h3>4. Phỏng vấn ứng viên</h3>
                        <p>Phỏng vấn là cơ hội để bạn đánh giá trực tiếp ứng viên và tìm hiểu xem họ có phù hợp với công ty
                            không.</p>
                        <h4>Các loại phỏng vấn:</h4>
                        <ul>
                            <li>**Phỏng vấn qua điện thoại:** Sàng lọc ban đầu, tiết kiệm thời gian.</li>
                            <li>**Phỏng vấn trực tiếp:** Đánh giá chi tiết hơn về kỹ năng, kinh nghiệm, thái độ.</li>
                            <li>**Phỏng vấn nhóm:** Đánh giá khả năng làm việc nhóm, giải quyết vấn đề.</li>
                        </ul>
                        <h4>Chuẩn bị cho buổi phỏng vấn:</h4>
                        <ul>
                            <li>Chuẩn bị câu hỏi phỏng vấn phù hợp.</li>
                            <li>Đảm bảo không gian phỏng vấn thoải mái.</li>
                            <li>Ghi chép lại kết quả phỏng vấn.</li>
                        </ul>
                    </div>

                    <div class="handbook-section">
                        <h3>5. Đánh giá và lựa chọn ứng viên</h3>
                        <p>Sau khi phỏng vấn, bạn cần đánh giá kết quả và lựa chọn ứng viên phù hợp nhất.</p>
                        <h4>Các tiêu chí đánh giá:</h4>
                        <ul>
                            <li>Kỹ năng chuyên môn</li>
                            <li>Kinh nghiệm làm việc</li>
                            <li>Khả năng giao tiếp</li>
                            <li>Khả năng làm việc nhóm</li>
                            <li>Phù hợp với văn hóa công ty</li>
                        </ul>
                        <p>Sử dụng các công cụ đánh giá (bài kiểm tra, v.v.) nếu cần thiết.</p>
                    </div>

                    <div class="handbook-section">
                        <h3>6. Đề nghị tuyển dụng và hội nhập nhân viên mới</h3>
                        <p>Khi đã chọn được ứng viên, bạn cần đưa ra đề nghị tuyển dụng chính thức. Sau khi ứng viên chấp nhận,
                            hãy lên kế hoạch hội nhập nhân viên mới để giúp họ nhanh chóng hòa nhập và làm việc hiệu quả.</p>
                        <h4>Nội dung đề nghị tuyển dụng:</h4>
                        <ul>
                            <li>Vị trí công việc</li>
                            <li>Mức lương và chế độ đãi ngộ</li>
                            <li>Thời gian bắt đầu làm việc</li>
                            <li>Các thông tin khác liên quan</li>
                        </ul>
                        <h4>Hoạt động hội nhập nhân viên mới:</h4>
                        <ul>
                            <li>Giới thiệu về công ty và văn hóa</li>
                            <li>Đào tạo về công việc</li>
                            <li>Gặp gỡ đồng nghiệp</li>
                            <li>Hỗ trợ trong thời gian đầu</li>
                        </ul>
                    </div>

                    </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>