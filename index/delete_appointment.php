<?php

include("conn.php");


if (isset($_GET['appointment_id'])) {

    $appointment_id = (int) $_GET['appointment_id'];


    if ($appointment_id <= 0) {
        die("Invalid appointment ID.");
    }


    $sql = "DELETE FROM appointments
            WHERE appointment_id = ?";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "i",
        $appointment_id
    );


    if ($stmt->execute()) {

        header("Location: appointments.php");
        exit;

    } else {

        echo "Error deleting appointment: " . $stmt->error;

    }


    $stmt->close();

}

$conn->close();

?>