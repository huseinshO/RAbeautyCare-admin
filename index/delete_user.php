<?php
require('conn.php');
$user_id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
if($user_id <= 0){
    die("Invalid user ID.");
}

$sql = "DELETE FROM users WHERE users_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if($stmt->execute() === TRUE){
    // echo "User deleted successfully.";
    echo "<script>window.location.href='users.php';</script>";
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

?>




?>