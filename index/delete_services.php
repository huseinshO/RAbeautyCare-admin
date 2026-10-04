<?php

include("conn.php");

// hon mncheck eza fi service_id
if (isset($_GET['service_id'])) {

    // hon mnakhod ID taba3 l service
    $service_id = (int) $_GET['service_id'];


    // validation taba3 ID
    if ($service_id <= 0) {
        die("Invalid Service ID.");
    }


    // hon mnمسح l service mn database
    $sql = "DELETE FROM services
            WHERE service_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $service_id);


    // execute delete
    if ($stmt->execute()) {

        // mnرجع 3a services.php
        header("Location: services.php");
        exit;

    } else {

        echo "Error deleting service: " . $stmt->error;
    }


    $stmt->close();
}


$conn->close();

?>
