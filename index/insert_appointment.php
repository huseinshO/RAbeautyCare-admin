<?php

include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customer_name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';
    $notes = trim($_POST['notes'] ?? '');


    // Validation

    if ($customer_name === '') {
        die("Customer name is required.");
    }

    if ($phone === '') {
        die("Phone is required.");
    }

    if ($service === '') {
        die("Service is required.");
    }

    if ($appointment_date === '') {
        die("Appointment date is required.");
    }

    if ($appointment_time === '') {
        die("Appointment time is required.");
    }


    // Insert appointment

    $sql = "INSERT INTO appointments
            (
                customer_name,
                phone,
                service,
                appointment_date,
                appointment_time,
                notes
            )
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);


    if (!$stmt) {
        die("Database error: " . $conn->error);
    }


    $stmt->bind_param(
        "ssssss",
        $customer_name,
        $phone,
        $service,
        $appointment_date,
        $appointment_time,
        $notes
    );


    // Execute

    if ($stmt->execute()) {

        // Client stays on the website
        header("Location: ../raweb/index.php?appointment=success");
        exit;

    } else {

        echo "Error adding appointment: " . $stmt->error;

    }


    $stmt->close();

} else {

    echo "Invalid request.";

}


$conn->close();

?>