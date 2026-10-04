<?php

include("conn.php");

// hon mncheck eza l values l asasiye mawjoude
if (
    isset($_POST['about_id']) &&
    isset($_POST['title']) &&
    isset($_POST['text_one']) &&
    isset($_POST['text_two'])
) {

    // hon mnakhod data mn form
    $about_id = (int) $_POST['about_id'];
    $title = trim($_POST['title']);
    $text_one = trim($_POST['text_one']);
    $text_two = trim($_POST['text_two']);

    // validation eno l fields mesh fade
    if (
        $about_id <= 0 ||
        $title === '' ||
        $text_one === '' ||
        $text_two === ''
    ) {
        die("Title and About Us texts are required.");
    }

    // hon mnجيب image l2dime mn database
    $sql = "SELECT image_one
            FROM about_us
            WHERE about_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $about_id);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("About Us not found.");
    }

    $about = $result->fetch_assoc();

    $old_image_one = $about['image_one'];

    $stmt->close();

    // hon mnجهز folder taba3 image
    $upload_folder = "../uploads/about/";

    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0777, true);
    }

    // variable lal image l jdide
    $new_image_one = null;

    // eza user 5tar image jdide
    if (isset($_FILES['image_one']) && $_FILES['image_one']['error'] !== UPLOAD_ERR_NO_FILE) {

        // eza fi error bel upload
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

        // unique name
        $new_image_one = uniqid('about_', true) . '.' . $extension;

        // full path
        $image_path = $upload_folder . $new_image_one;

        // move image
        if (!move_uploaded_file($_FILES['image_one']['tmp_name'], $image_path)) {
            die("Error saving About Us image.");
        }
    }

    // eza ma 5tar image jdide, l2dime btضل
    $image_one = $new_image_one !== null ? $new_image_one : $old_image_one;

    // update lal database
    // button_text, button_link w image_two ma 3adna nsta3melon
    $sql = "UPDATE about_us
            SET title = ?,
                text_one = ?,
                text_two = ?,
                image_one = ?
            WHERE about_id = ?";

    // prepare krml security
    $stmt = $conn->prepare($sql);

    // 4 strings + 1 integer
    $stmt->bind_param(
        "ssssi",
        $title,
        $text_one,
        $text_two,
        $image_one,
        $about_id
    );

    // execute update
    if ($stmt->execute()) {

        // eza image jdide, mnمسح l2dime
        if ($new_image_one !== null && !empty($old_image_one)) {

            $old_path = $upload_folder . $old_image_one;

            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }

        // mnرجع 3a about_us.php
        header("Location: about_us.php");
        exit;

    } else {

        echo "Error updating About Us: " . $stmt->error;
    }

    // close statement
    $stmt->close();
}

// close database
$conn->close();

?>
