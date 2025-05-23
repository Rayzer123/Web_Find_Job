<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tuyển Dụng & Tìm Việc Làm - CareerLink.vn</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body { font-family: Arial, sans-serif; }
    .navbar-brand img { height: 40px; }
    .job-search-input { max-width: 800px; }
    .feature-section { padding: 2rem 0; background-color: #f8f9fa; }
    .job-card { box-shadow: 0 0 5px rgba(0,0,0,0.1); border-radius: 10px; padding: 1rem; margin: 1rem 0; }
    .filter-section { background: #ffffff; padding: 1rem; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.05); margin-bottom: 2rem; }
    .filter-section h5 { margin-top: 1rem; }
  </style>
</head>
<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="../img/logo_CNTT_QNU.jpg" alt="CareerLink"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="#">Ngành nghề / Địa điểm</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Công ty</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Cẩm nang việc làm</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Mẫu CV</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <a href="#" class="me-3"><i class="bi bi-globe"></i> vi</a>
          <a href="Giaodiendangnhap.php" class="btn btn-outline-primary me-2">Đăng nhập</a>
          <a href="dangkyntd.php" class="btn btn-outline-secondary me-2">Đăng ký</a>
          <a href="Dangnhapntd.php" class="btn btn-primary">Nhà tuyển dụng</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Search Section -->
  <div class="container py-4">
    <form class="d-flex flex-column flex-md-row align-items-center job-search-input">
      <input type="text" class="form-control me-md-2 mb-2 mb-md-0" placeholder="Nhập tên vị trí, công ty, từ khoá">
      <input type="text" class="form-control me-md-2 mb-2 mb-md-0" placeholder="Nhập tỉnh, thành phố">
      <button class="btn btn-success" type="submit"><i class="bi bi-search"></i> Tìm kiếm</button>
    </form>

    <!-- Advanced Filters -->
    <div class="filter-section mt-4">
      <h5>Lọc nâng cao</h5>
      <div class="row">
        <div class="col-md-3">
          <label>Ngành nghề</label>
          <div><input type="checkbox" name="nn[]" value="IT"> Công Nghệ Thông Tin</div>
          <div><input type="checkbox" name="nn[]" value="Marketing"> Marketing</div>
          <div><input type="checkbox" name="nn[]" value="HR"> Nhân Sự</div>
        </div>
        <div class="col-md-3">
          <label>Cấp bậc</label>
          <div><input type="checkbox" name="cb[]" value="Junior"> Junior</div>
          <div><input type="checkbox" name="cb[]" value="Mid"> Mid</div>
          <div><input type="checkbox" name="cb[]" value="Senior"> Senior</div>
        </div>
        <div class="col-md-3">
          <label>Kinh nghiệm</label>
          <div><input type="checkbox" name="kn[]" value="0-1"> 0-1 năm</div>
          <div><input type="checkbox" name="kn[]" value="2-3"> 2-3 năm</div>
          <div><input type="checkbox" name="kn[]" value="3-5"> 3-5 năm</div>
        </div>
        <div class="col-md-3">
          <label>Loại công việc</label>
          <div><input type="checkbox" name="cv[]" value="fulltime"> Toàn thời gian</div>
          <div><input type="checkbox" name="cv[]" value="parttime"> Bán thời gian</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Featured Jobs -->
  <div class="container feature-section">
    <h3 class="mb-4">Việc Làm Hấp Dẫn</h3>
    <div class="row">
      <div class="col-md-4">
        <div class="job-card">
          <h5>Kỹ sư phần mềm</h5>
          <p>Công ty ABC - TP. Hồ Chí Minh</p>
          <p><i class="bi bi-briefcase"></i> Toàn thời gian | <i class="bi bi-currency-dollar"></i> 15-20 triệu</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="job-card">
          <h5>Chuyên viên Marketing</h5>
          <p>Công ty XYZ - Hà Nội</p>
          <p><i class="bi bi-briefcase"></i> Toàn thời gian | <i class="bi bi-currency-dollar"></i> 10-15 triệu</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="job-card">
          <h5>Nhân viên nhân sự</h5>
          <p>Công ty DEF - Đà Nẵng</p>
          <p><i class="bi bi-briefcase"></i> Bán thời gian | <i class="bi bi-currency-dollar"></i> 8-10 triệu</p>
        </div>
      </div>
    </div>
    <!-- Pagination -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <a class="page-link">Trước</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Sau</a>
        </li>
      </ul>
    </nav>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
