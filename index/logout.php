<?php session_start();


session_unset();
session_destroy();//btmsh lsession
// echo "<script>alert('You have been logged out successfully.');"
echo "<script>window.location.href='login.php';</script>";//btrj3ne 3ala el login page eza luser 3ml logout



?>