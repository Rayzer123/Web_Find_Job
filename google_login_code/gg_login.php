<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('
491106708943-qu1regve6saeq1efm4s1s52ttrspmfg9.apps.googleusercontent.com');
$client->setClientSecret('YOUR_CLIENT_SECRET_HERE');
$client->setRedirectUri('http://localhost:8080/webtv/gg_callback.php');
$client->addScope("email");
$client->addScope("profile");

$login_url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Google</title>
</head>
<body>
    <a href="<?= htmlspecialchars($login_url) ?>">
        <button>Đăng nhập với Google</button>
    </a>
</body>
</html>
