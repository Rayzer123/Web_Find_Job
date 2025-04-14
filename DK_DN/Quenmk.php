<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h2>Quên mật khẩu</h2>
        <p>Hãy nhập email để chúng tôi gửi bạn link đặt lại mật khẩu.</p>
        <form>
            <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Xác nhận</button>
        </form>
    </div>
</body>
</html>
