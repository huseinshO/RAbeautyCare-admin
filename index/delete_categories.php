<?php

include("conn.php");

if (isset($_GET['cat_id'])) {

    // hon mnakhod ID taba3 l category
    $categories_id = (int) $_GET['cat_id'];

    // hon mncheck eza l ID sah
    if ($categories_id <= 0) {
        die("Invalid category ID.");
    }


    // hon mnجيب essem l sora taba3 l category
    // la2an badna nmsaha mn folder ba3d ma nmsah l category
    $sql = "SELECT category_image
            FROM categories
            WHERE categories_id = ?";

    // prepare krml security w prevent SQL Injection
    $stmt = $conn->prepare($sql);

    // i = category ID
    $stmt->bind_param("i", $categories_id);

    // execute lal SELECT
    $stmt->execute();

    // mnجيب l result
    $result = $stmt->get_result();

    // variable la n7ot fiya essem l sora
    $category_image = null;

    // eza l category mawjoude
    if ($result->num_rows > 0) {

        // mnجيب l row
        $row = $result->fetch_assoc();

        // mnجيب essem l sora
        $category_image = $row['category_image'];
    }

    // close lal statement
    $stmt->close();


    // hon mnمسح l category mn database
    $sql = "DELETE FROM categories
            WHERE categories_id = ?";

    // prepare lal DELETE query
    $stmt = $conn->prepare($sql);

    // i = category ID
    $stmt->bind_param("i", $categories_id);


    // execute l DELETE query
    if ($stmt->execute()) {

        // eza fi sora related lal category
        if (!empty($category_image)) {

            // hon mnحدد path taba3 l sora
            $image_path = "../uploads/categories/" . $category_image;

            // eza l sora mawjoude, mnمسحها mn folder
            if (file_exists($image_path)) {

                unlink($image_path);
            }
        }


        // ba3d ma nmsah l category w l sora
        // mnرجع 3a categories.php
        header("Location: categories.php");
        exit;

    } else {

        // eza fi error bel DELETE
        echo "Error deleting category: " . $stmt->error;
    }


    // close lal statement
    $stmt->close();
}


// close lal database connection
$conn->close();

?>