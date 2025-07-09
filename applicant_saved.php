<?php
// Công việc đã lưu
session_start();
include '../db_connect.php';
if(!isset($_SESSION['user_id'])){
	header('location: applicant_login.php');
	exit();
}
$user_id =(int) $_SESSION['user_id'];
$sql = "SELECT jobs.*, employers.company_name, employers.logo
			FROM jobs_saved
			JOIN jobs ON jobs_saved.job_id = jobs.id
			JOIN employers ON jobs.employer_id = employers.id
			WHERE jobs_saved.user_id = $user_id
			ORDER BY jobs_saved.saved_at DESC";
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Công việc đã lưu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        body { background: #f6f8fa;}
        .saved-box {background: #fff; border-radius: 14px; box-shadow: 0 2px 8px #e9ecef; padding: 26px;}
        .empty-box {border: 2px dashed #bcd8f8; border-radius: 16px; padding: 32px 0; text-align: center; background: #fafdff;}
        .empty-box .icon {font-size: 2.8rem; color: #85b8e6; margin-bottom: 12px;}
    </style>
</head>
<body>
<?php include 'navbar_applicant.php'; ?>
<div class="container my-4">
    <div class="saved-box">
        <h5 class="mb-4 text-primary fw-bold">Công việc đã lưu (<?=mysqli_num_rows($result) ?>)</h5>
        <?php if(mysqli_num_rows($result)==0): ?>
            <div class="empty-box">
                <div class="icon">🤍</div>
                Lưu lại việc làm bạn quan tâm để xem lại dễ dàng!<br>
                <a href="applicant_jobs.php" class="btn btn-primary mt-2">Đến trang tìm việc</a>
            </div>
		    <?php else: ?>
				<?php while ($job = mysqli_fetch_assoc($result)): ?>
						<div class="job-card p-3 mb-3 border rounded d-flex align-items-center">
						<!-- Logo -->
							<?php if ($job['logo']): ?>
										<img src="../upload/<?= htmlspecialchars($job['logo']) ?>" class="me-3" width="80" height="80" alt="<?= htmlspecialchars($job['company_name']) ?>">
							<?php else: ?>
										<img src="../assets/logoweb.jpg" class="me-3" width="80" height="80" alt="Logo">
							<?php endif; ?>
						<!-- Nội dung -->
						<div class="flex-grow-1">
							<div class="fw-bold">
								<a href="applicant_job_detail.php?id=<?= $job['id'] ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($job['title']) ?></a>
							</div>
							<div class="text-muted"><?= htmlspecialchars($job['company_name']) ?> • <?= htmlspecialchars($job['location']) ?></div>
							<div class="text-muted"><?= htmlspecialchars($job['salary']) ?></div>
							<div class="small text-muted">Đăng ngày: <?= date('d/m/Y', strtotime($job['created_at'])) ?></div>
						</div>
						<!-- Nút huỷ lưu -->
						<div>
							<button class="btn btn-danger btn-sm unsave-job-btn" data-job-id="<?= $job['id'] ?>">Huỷ lưu</button>
						</div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
    </div>
</div>
<?php include 'footer_applicant.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.unsave-job-btn', function() {
    var button = $(this);
    var jobId = button.data('job-id');
    $.post('save-unsave_Job.php', { job_id: jobId, action: 'unsave' }, function(response) {
        if (response === 'unsaved') {
            button.closest('.job-card').remove();
        } else {
            alert('Không thể huỷ lưu công việc!');
        }
    });
});
</script>
</body>
</html>