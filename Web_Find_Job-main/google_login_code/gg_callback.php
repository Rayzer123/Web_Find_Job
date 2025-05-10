<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID_HERE');
$client->setClientSecret('YOUR_CLIENT_SECRET_HERE');
$client->setRedirectUri('http://localhost:8080/webtv/gg_callback.php');

$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        echo "<h2>Đăng nhập thành công!</h2>";
        echo "<p>Tên: " . $userInfo->name . "</p>";
        echo "<p>Email: " . $userInfo->email . "</p>";
        echo "<img src='" . $userInfo->picture . "' alt='Avatar'>";
    } else {
        echo "Lỗi xác thực: " . $token["error"];
    }
} else {
    echo "Không có mã xác thực!";
}
