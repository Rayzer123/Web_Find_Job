<?php
include('../db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])) header('Location: applicant_login.php');
if(isset($_POST['apply'])) {
    $job_id = $_POST['job_id'];
    $user_id = $_POST['user_id'];
    $cv_path = 'uploads/' . time() . '_' . basename($_FILES['cv']['name']);
    move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path);
    $sql = "INSERT INTO applications (user_id, job_id, cv_path, applied_at) VALUES ('$user_id', '$job_id', '$cv_path', NOW())";
    mysqli_query($conn, $sql);
    echo "<script>alert('Ứng tuyển thành công!'); window.location='applicant_jobs.php';</script>";
}
?>