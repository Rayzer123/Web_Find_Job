<?php
$conn = mysqli_connect('localhost', 'root', '', 'findjob');
if(!$conn){
    die("Kết nối database thất bại: " . mysqli_connect_error());
}
?>