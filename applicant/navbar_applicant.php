<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
      <img src="https://hoitinhoc.binhdinh.gov.vn/wp-content/uploads/2019/04/image001.png" class="me-2" alt="Logo" style="height:32px;">
      Web Tìm Việc
    </a>
    <form class="d-none d-lg-flex ms-3 flex-grow-1" style="max-width: 440px;">
      <input type="text" class="form-control" placeholder="Nhập vị trí, công ty, từ khóa...">
      <button class="btn btn-primary ms-2" type="submit"><i class="bi bi-search"></i></button>
    </form>
    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item">
        <a class="nav-link" href="applicant_profile.php"><i class="bi bi-person-vcard me-1"></i> Hồ sơ xin việc</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="applicant_saved.php"><i class="bi bi-heart me-1"></i> Việc đã lưu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="applicant_applied.php"><i class="bi bi-send me-1"></i> Việc đã ứng tuyển</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="applicant_notifications.php"><i class="bi bi-bell me-1"></i> Thông báo việc làm</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="avatar-circle me-2" style="display:inline-block;width:32px;height:32px;background:#f0f2f5;border-radius:50%;text-align:center;line-height:32px;font-weight:bold;">
            <?= strtoupper(substr($_SESSION['user_name'] ?? 'UV',0,1)) ?>
          </span>
          <?= htmlspecialchars($_SESSION['user_name'] ?? 'Ứng viên') ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
          <li><a class="dropdown-item" href="applicant_profile.php"><i class="bi bi-person-vcard me-2"></i> Hồ sơ xin việc</a></li>
          <li><a class="dropdown-item" href="applicant_saved.php"><i class="bi bi-heart me-2"></i> Việc đã lưu</a></li>
          <li><a class="dropdown-item" href="applicant_applied.php"><i class="bi bi-send me-2"></i> Việc đã ứng tuyển</a></li>
          <li><a class="dropdown-item" href="applicant_notifications.php"><i class="bi bi-bell me-2"></i> Thông báo việc làm</a></li>
          <li><a class="dropdown-item" href="applicant_account.php"><i class="bi bi-person me-2"></i> Tài khoản</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="applicant_logout.php"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">