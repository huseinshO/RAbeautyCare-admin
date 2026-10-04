<?php

include("conn.php");

// hon mncheck eno kel l values mawjoude
if (
    isset($_POST['service_id']) &&
    isset($_POST['service_name']) &&
    isset($_POST['description']) &&
    isset($_POST['is_active'])
) {

    // hon mnakhod data mn form
    $service_id = (int) $_POST['service_id'];

    $service_name = trim($_POST['service_name']);

    $description = trim($_POST['description']);

    $icon = trim($_POST['icon'] ?? '');

    $is_active = (int) $_POST['is_active'];


    // validation
    if ($service_id <= 0 || $service_name === '' || $description === '') {
        die("Service ID, name and description are required.");
    }


    // hon mnupdate l service
    $sql = "UPDATE services
            SET service_name = ?,
                description = ?,
                icon = ?,
                is_active = ?
            WHERE service_id = ?";

    // prepare krml security
    $stmt = $conn->prepare($sql);

    // 3 strings + 2 integers
    $stmt->bind_param(
        "sssii",
        $service_name,
        $description,
        $icon,
        $is_active,
        $service_id
    );


    // execute update
    if ($stmt->execute()) {

        // mnرجع 3a services.php
        header("Location: services.php");
        exit;

    } else {

        echo "Error updating service: " . $stmt->error;
    }


    $stmt->close();
}


$conn->close();

?>
