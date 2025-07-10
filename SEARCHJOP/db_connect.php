<?php
$conn = mysqli_connect('sql308.infinityfree.com', 'if0_39434538', 'eQufeKENXqfiW', 'if0_39434538_findjob');
if(!$conn){
    die("Kết nối database thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>