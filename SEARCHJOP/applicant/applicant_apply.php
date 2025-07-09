<?php
include('../db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])) header('Location: applicant_login.php');
if(isset($_POST['apply'])) {
    $job_id = $_POST['job_id'];
    $job_employer_id = $_POST['job_employer_id'];
    $user_id = $_SESSION['user_id'];
    $sql1 = "select * from cover_letters where user_id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cv_path = $row['content_path'];
    $sql = "INSERT INTO applications (user_id, job_id, cv_path, applied_at, resume_id) VALUES ('$user_id', '$job_id', '$cv_path', NOW(), '$job_employer_id')";
    mysqli_query($conn, $sql);
    echo "<script>alert('Ứng tuyển thành công!'); window.location='applicant_jobs.php';</script>";
}
?>