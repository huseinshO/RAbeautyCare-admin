<?php

include("conn.php");

// hon mncheck eza fi about_id
if (isset($_GET['about_id'])) {

    // hon mnakhod ID taba3 About Us
    $about_id = (int) $_GET['about_id'];

    // validation taba3 ID
    if ($about_id <= 0) {
        die("Invalid About Us ID.");
    }

    // hon mnجيب essem image l2dime
    $sql = "SELECT image_one
            FROM about_us
            WHERE about_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $about_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $about = null;

    if ($result->num_rows > 0) {

        // hon mnجيب row
        $about = $result->fetch_assoc();
    }

    $stmt->close();

    // hon mnمسح About Us mn database
    $sql = "DELETE FROM about_us
            WHERE about_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $about_id);

    // execute delete
    if ($stmt->execute()) {

        // folder taba3 image
        $upload_folder = "../uploads/about/";

        // eza fi image, mnمسحها
        if (!empty($about['image_one'])) {

            $image_path = $upload_folder . $about['image_one'];

            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // mnرجع 3a about_us.php
        header("Location: about_us.php");
        exit;

    } else {

        echo "Error deleting About Us: " . $stmt->error;
    }

    // close statement
    $stmt->close();
}

// close database connection
$conn->close();

?>
