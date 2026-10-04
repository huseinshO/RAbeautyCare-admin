<?php //3m jebon mn safhet update_form_user.php
 
// var_dump($_POST);exit;
include('conn.php');
if(isset($_POST['user_id']) && isset($_POST['username']) && isset($_POST['role'])) {
    $users_id = $_POST['user_id'];
    $username = trim($_POST['username']);
    $role = trim($_POST['role']);

    if ($username === '' || $role === '') {
        die("Username and role are required.");
    }

    $sql = "UPDATE users SET usersname = ?, role = ? WHERE users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $role, $users_id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
        header("Location: users.php");
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $stmt->close();
}
?>













