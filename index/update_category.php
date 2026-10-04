<?php

// var_dump($_POST);exit;

include('conn.php');

if(isset($_POST['cat_id']) && isset($_POST['cat_name']) && isset($_POST['des'])) {
    // hon mncheck eza l values l asasiye mawjoude bl POST

    $categories_id = $_POST['cat_id'];
    // hon mnakhod ID taba3 l category

    $cat_name = trim($_POST['cat_name']);
    // hon mnakhod essem l category w trim krml nshil l spaces

    $description = trim($_POST['des']);
    // hon mnakhod l description w trim krml nshil l spaces


    if ($cat_name === '' || $description === '') { 
        // hata lw fe required bl form hyde lzm tnhat laan hydeke mesh aweye

        die("Category name and description are required.");
        // eza wa7ad mennon fade, nwa2ef l code w n3ti message
    }


    // hon mncheck eza fi sora jdide mn l user

    $new_image_name = null;

    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === 0) {

        // hon mnakhod essem l sora jdide
        $image_name = $_FILES['category_image']['name'];

        // hon mnakhod temporary path taba3 l sora
        $image_tmp = $_FILES['category_image']['tmp_name'];


        // hon mn7ot l extensions lmasmou7a

        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];


        // hon mnakhod extension taba3 l sora

        $image_extension = strtolower(
            pathinfo($image_name, PATHINFO_EXTENSION)
        );


        // hon mncheck eza extension masmou7a

        if (!in_array($image_extension, $allowed_types)) {

            die("Only JPG, JPEG, PNG and WEBP images are allowed.");

        }


        // hon mn3amel essem unique lal sora
        // krml ma ysir conflict ma3 sora tene

        $new_image_name = uniqid('category_', true) . '.' . $image_extension;


        // hon mn7added folder taba3 categories images

        $upload_folder = "../uploads/categories/";


        // eza l folder mesh mawjoude, mn3amlo
        if (!is_dir($upload_folder)) {

            mkdir($upload_folder, 0777, true);

        }


        // hon mn3amel full path taba3 l sora

        $image_path = $upload_folder . $new_image_name;


        // hon mn2oul l sora mn temporary folder 3a uploads/categories

        if (!move_uploaded_file($image_tmp, $image_path)) {

            die("Error uploading category image.");

        }

    }


    // hon mncheck eza fi sora jdide aw la2

    if ($new_image_name !== null) {

        // eza fi sora jdide, mnupdate l name taba3 l sora ma3 category name w description

        $sql = "UPDATE categories 
                SET categories_name = ?, description = ?, category_image = ? 
                WHERE categories_id = ?";

        // prepare krml security w prevent SQL Injection

        $stmt = $conn->prepare($sql);

        // s = category name
        // s = description
        // s = image name
        // i = category id

        $stmt->bind_param(
            "sssi",
            $cat_name,
            $description,
            $new_image_name,
            $categories_id
        );

    } else {

        // eza ma fi sora jdide, mnupdate bas name w description
        // l sora l2dime btضل متل ma hye

        $sql = "UPDATE categories 
                SET categories_name = ?, description = ? 
                WHERE categories_id = ?";

        // prepare lal query

        $stmt = $conn->prepare($sql);

        // s = category name
        // s = description
        // i = category id

        $stmt->bind_param(
            "ssi",
            $cat_name,
            $description,
            $categories_id
        );

    }


    // hon mnexecute l UPDATE query

    if ($stmt->execute()) {

        // eza l update نجح

        echo "Category updated successfully.";

        // mnrou7 3a categories.php

        header("Location: categories.php");

        // nwa2ef l code ba3d l redirect

        exit;

    } else {

        // eza fi error bel update

        echo "Error updating category: " . $conn->error;

    }


    // close lal statement

    $stmt->close();

}


// close lal database connection

$conn->close();

?>