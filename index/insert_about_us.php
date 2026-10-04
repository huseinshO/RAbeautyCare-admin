<?php

include("conn.php");

// hon mncheck eza l form tba3at POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // hon mnakhod l values mn form
    $title = trim($_POST['title']);
    $text_one = trim($_POST['text_one']);
    $text_two = trim($_POST['text_two']);

    // hon mncheck l fields l asasiye
    if ($title === '' || $text_one === '' || $text_two === '') {
        die("Title and About Us texts are required.");
    }

    // hon mnجهز folder taba3 About Us image
    $upload_folder = "../uploads/about/";

    // eza l folder mesh mawjoude, mn3amlo
    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0777, true);
    }

    // hon mncheck image one
    if (!isset($_FILES['image_one']) || $_FILES['image_one']['error'] === UPLOAD_ERR_NO_FILE) {
        die("About Us image is required.");
    }

    // eza sar error bel upload
    if ($_FILES['image_one']['error'] !== UPLOAD_ERR_OK) {
        die("Error uploading About Us image.");
    }

    // allowed extensions
    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

    // mnجيب extension
    $extension = strtolower(pathinfo($_FILES['image_one']['name'], PATHINFO_EXTENSION));

    // mncheck extension
    if (!in_array($extension, $allowed_types)) {
        die("Only JPG, JPEG, PNG and WEBP images are allowed.");
    }

    // mn3amel essem unique
    $image_one = uniqid('about_', true) . '.' . $extension;

    // full path
    $image_path = $upload_folder . $image_one;

    // mnنقل l sora 3a uploads/about
    if (!move_uploaded_file($_FILES['image_one']['tmp_name'], $image_path)) {
        die("Error saving About Us image.");
    }

    // hon mnضيف About Us 3a database
    // button_text, button_link w image_two ma 3adna nsta3melon
    $sql = "INSERT INTO about_us
            (title, text_one, text_two, image_one)
            VALUES (?, ?, ?, ?)";

    // prepare krml security
    $stmt = $conn->prepare($sql);

    // kelon strings, ya3ne 4 s
    $stmt->bind_param(
        "ssss",
        $title,
        $text_one,
        $text_two,
        $image_one
    );

    // execute
    if ($stmt->execute()) {

        // mnرجع 3a about_us.php
        header("Location: about_us.php");
        exit;

    } else {

        echo "Error adding About Us: " . $stmt->error;
    }

    // close statement
    $stmt->close();
}

// close database
$conn->close();

?>
