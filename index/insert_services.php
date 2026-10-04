<?php

include("conn.php");

// hon mncheck eno l form tba3at POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // hon mnakhod l values mn form
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon'] ?? '');
    $is_active = (int) $_POST['is_active'];


    // validation
    if ($service_name === '' || $description === '') {
        die("Service name and description are required.");
    }


    // hon mncheck eza l service already exists
    $sql = "SELECT service_id
            FROM services
            WHERE service_name = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $service_name);

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        echo "Service already exists.";

    } else {

        // hon mnضيف l service 3a database
        $sql = "INSERT INTO services
                (service_name, description, icon, is_active)
                VALUES (?, ?, ?, ?)";

        $insertStmt = $conn->prepare($sql);

        // 3anna 3 strings + 1 integer
        $insertStmt->bind_param(
            "sssi",
            $service_name,
            $description,
            $icon,
            $is_active
        );


        // execute insert
        if ($insertStmt->execute()) {

            // mnرجع 3a services.php
            header("Location: services.php");
            exit;

        } else {

            echo "Error adding service: " . $insertStmt->error;
        }

        $insertStmt->close();
    }


    $stmt->close();
}

$conn->close();

?>
