<?php
session_start();
if (!isset($_SESSION['employer_id'])) {
    header('Location: employer_login.php');
    exit();
}

// Kết nối CSDL
include('../db_connect.php');

$message = "";

// Xử lý xóa tin
if (isset($_POST['delete_job']) && isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);
    $employer_id = $_SESSION['employer_id'];
    $sql = "DELETE FROM jobs WHERE id = ? AND employer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $job_id, $employer_id);
    if ($stmt->execute()) {
        $message = "Đã xóa tin tuyển dụng.";
    } else {
        $message = "Lỗi xóa tin tuyển dụng.";
    }
}

// Xử lý sửa tin
if (isset($_POST['edit_job'])) {
    $job_id = intval($_POST['job_id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $job_type = $_POST['job_type'];
    $deadline = $_POST['deadline'];
    $employer_id = $_SESSION['employer_id'];
    $sql = "UPDATE jobs SET title = ?, description = ?, requirements = ?, location = ?, salary = ?, job_type = ?, deadline = ? WHERE id = ? AND employer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssii", $title, $description, $requirements, $location, $salary, $job_type, $deadline, $job_id, $employer_id);
    if ($stmt->execute()) {
        $message = "Cập nhật tin tuyển dụng thành công.";
    } else {
        $message = "Lỗi cập nhật tin tuyển dụng.";
    }
}

// Lấy danh sách việc làm theo ID nhà tuyển dụng trong session
$employer_id = $_SESSION['employer_id'];
$sql = "SELECT * FROM jobs WHERE employer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$jobs = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Công việc của tôi | Web Tìm Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {background: #f6f8fa;}
        .sidebar {min-height: 100vh; background: #fff; border-right: 1px solid #e6e9ef;}
        .sidebar .nav-link.active, .sidebar .nav-link:focus {background: #e3f1ff; color: #004b8d !important; font-weight: 600;}
        .sidebar .nav-link {color: #333;}
        .sidebar .nav-link i {width: 20px;}
        .sidebar-bottom {position: absolute; bottom: 0; width: 220px; padding: 12px; font-size: 14px; color: #888;}
        .main-content {background: #f6f8fa; min-height: 100vh;}
        .dashboard-header {color: #004b8d; font-size: 22px; margin-bottom: 20px;}
        .dashboard-card {background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px #aaa3; margin-bottom: 20px;}
        .job-card {border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 15px;}
        .job-title {font-weight: bold; margin-bottom: 5px;}
        .job-info {margin-bottom: 8px;}
        .edit-button, .delete-button {background-color: #004b8d; border-color: #004b8d; color: #fff; padding: 5px 10px; border-radius: 5px; cursor: pointer; margin-right: 5px;}
        .edit-button:hover, .delete-button:hover {background-color: #003666; border-color: #003666;}
        .delete-button {background-color: #dc3545; border-color: #dc3545;}
        .delete-button:hover {background-color: #c82333; border-color: #c82333;}
        .modal-title {color: #004b8d;}
        .form-label {font-weight: bold;}
        .form-control {margin-bottom: 10px;}
        .btn-primary {background-color: #004b8d; border-color: #004b8d;}
        .btn-primary:hover {background-color: #003666; border-color: #003666;}
        .btn-secondary {background-color: #6c757d; border-color: #6c757d;}
        .btn-secondary:hover {background-color: #545b62; border-color: #4e555b;}
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
                    <a class="nav-link active" href="employer_jobs.php"><i class="bi bi-briefcase"></i> Công việc của tôi</a>
                    <a class="nav-link" href="employer_post_job.php"><i class="bi bi-plus-square"></i> Đăng Tuyển dụng</a>
                    <div class="ps-2 pt-2 pb-1 text-secondary small">Ứng viên của tôi</div>
                    <a class="nav-link" href="employer_search.php"><i class="bi bi-search"></i> Tìm kiếm tài năng</a>
                    <a class="nav-link" href="employer_applicants.php"><i class="bi bi-envelope"></i> Thư xin việc đã nhận</a>
                    <a class="nav-link" href="employer_saved.php"><i class="bi bi-bookmark"></i> Tài năng đã lưu</a>
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
                <h2 class="dashboard-header">Công việc của tôi</h2>
                <?php if ($message): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
                <div class="dashboard-card">
                    <?php if (empty($jobs)): ?>
                        <p>Bạn chưa đăng tin tuyển dụng nào.</p>
                    <?php else: ?>
                        <?php foreach ($jobs as $job): ?>
                            <div class="job-card" id="job-<?= $job['id'] ?>">
                                <h5 class="job-title"><?= htmlspecialchars($job['title']) ?></h5>
                                <p class="job-info">Địa điểm: <?= htmlspecialchars($job['location']) ?></p>
                                <p class="job-info">Mức lương: <?= htmlspecialchars($job['salary']) ?></p>
                                <p class="job-info">Loại công việc: <?= htmlspecialchars($job['job_type']) ?></p>
                                <button class="edit-button" onclick="showEditForm(<?= htmlspecialchars(json_encode($job)) ?>)">Sửa</button>
                                <button class="delete-button" onclick="showDeleteModal(<?= $job['id'] ?>)">Xóa</button>
                               <button class="btn btn-primary" 
                                     onclick="window.location.href='employer_applicants.php?job_id=<?= $job['id'] ?>'">
                                        Xem ứng viên
                                    </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Form Sửa -->
                <div class="dashboard-card" id="editJobForm" style="display: none;">
                    <h3>Sửa tin tuyển dụng</h3>
                    <form method="post" action="employer_jobs.php">
                        <input type="hidden" id="edit_job_id" name="job_id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Tiêu đề công việc</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Mô tả công việc</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_requirements" class="form-label">Yêu cầu</label>
                            <textarea class="form-control" id="edit_requirements" name="requirements" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_location" class="form-label">Địa điểm</label>
                            <input type="text" class="form-control" id="edit_location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_salary" class="form-label">Mức lương</label>
                            <input type="text" class="form-control" id="edit_salary" name="salary" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_job_type" class="form-label">Loại công việc</label>
                            <select class="form-select" id="edit_job_type" name="job_type" required>
                                <option value="Toàn thời gian">Toàn thời gian</option>
                                <option value="Bán thời gian">Bán thời gian</option>
                                <option value="Thực tập">Thực tập</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deadline" class="form-label">Hạn nộp hồ sơ</label>
                            <input type="date" class="form-control" id="edit_deadline" name="deadline" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="edit_job">Lưu</button>
                        <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Hủy</button>
                    </form>
                </div>

                <!-- Modal Xác nhận xóa -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <form method="post" action="employer_jobs.php">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn muốn xóa tin tuyển dụng này không?
                          <input type="hidden" name="job_id" id="delete_job_id">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <button type="submit" name="delete_job" class="btn btn-danger">Xóa</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị form sửa và nạp dữ liệu lên form
        function showEditForm(job) {
            document.getElementById("editJobForm").style.display = "block";
            document.getElementById("edit_job_id").value = job.id;
            document.getElementById("edit_title").value = job.title;
            document.getElementById("edit_description").value = job.description;
            document.getElementById("edit_requirements").value = job.requirements;
            document.getElementById("edit_location").value = job.location;
            document.getElementById("edit_salary").value = job.salary;
            document.getElementById("edit_job_type").value = job.job_type;
            document.getElementById("edit_deadline").value = job.deadline;
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
        function hideEditForm() {
            document.getElementById("editJobForm").style.display = "none";
        }
        // Hiển thị modal xác nhận xóa
        function showDeleteModal(jobId) {
            document.getElementById("delete_job_id").value = jobId;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>