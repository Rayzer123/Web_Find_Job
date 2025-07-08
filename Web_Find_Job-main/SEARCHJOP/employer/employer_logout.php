<?php
session_start();
session_destroy();
header('Location: employer_login.php');
?>