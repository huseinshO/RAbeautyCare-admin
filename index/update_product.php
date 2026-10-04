<?php

include('conn.php');

if (
    !isset($_POST['prod_id']) ||
    !isset($_POST['prod_name']) || //hsb lform name
    !isset($_POST['categories_id']) ||
    !isset($_POST['price'])
) {
    die("Missing required fields.");
}

$product_id    = (int) $_POST['prod_id'];
$products_name = trim($_POST['prod_name']);//form name
$categories_id = (int) $_POST['categories_id'];
$price         = (float) $_POST['price'];


// Validation
if ($product_id <= 0) {
    die("Invalid product ID.");
}

if ($products_name === '') {
    die("Product name is required.");
}

if ($categories_id <= 0) {
    die("Please select a category.");
}

if ($price < 0) {
    die("Invalid product price.");
}


// Get old image
$old_image = '';

$get_old_image = $conn->prepare("
    SELECT products_image 
    FROM products 
    WHERE products_id = ?
");

$get_old_image->bind_param("i", $product_id);
$get_old_image->execute();

$result = $get_old_image->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

$old_image = $product['products_image'];

$get_old_image->close();


// Check if a new image was uploaded
$new_image_uploaded = (
    isset($_FILES['products_image']) &&
    $_FILES['products_image']['error'] === UPLOAD_ERR_OK &&
    !empty($_FILES['products_image']['name'])
);


if ($new_image_uploaded) {

    $original_name = $_FILES['products_image']['name'];
    $tmp_name      = $_FILES['products_image']['tmp_name'];
    $file_size     = $_FILES['products_image']['size'];

    $extension = strtolower(
        pathinfo($original_name, PATHINFO_EXTENSION)
    );

    $allowed_extensions = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];

    if (!in_array($extension, $allowed_extensions)) {
        die("Invalid image format.");
    }

    $max_size = 2 * 1024 * 1024;

    if ($file_size > $max_size) {
        die("Image size must not exceed 2 MB.");
    }


    // Generate new image name
    $file_name = uniqid('product_', true) . '.' . $extension;

    $upload_folder = '../uploads/products/';
    $destination   = $upload_folder . $file_name;


    // Upload new image
    if (!move_uploaded_file($tmp_name, $destination)) {
        die("Failed to upload image.");
    }


    // Update product WITH new image
    $sql = "
        UPDATE products 
        SET 
            products_name = ?,
            categories_id = ?,
            price = ?,
            products_image = ?
        WHERE products_id = ?
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sidsi",
        $products_name,
        $categories_id,
        $price,
        $file_name,
        $product_id
    );


    if ($stmt->execute()) {

        // Delete old image
        if (!empty($old_image)) {

            $old_image_path = $upload_folder . $old_image;

            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        header("Location: products.php");
        exit;

    } else {

        // Database update failed
        // Delete the newly uploaded image because it is no longer needed
        if (file_exists($destination)) {
            unlink($destination);
        }

        echo "Error updating product: " . $stmt->error;
    }


} else {

    // Update WITHOUT changing image
    $sql = "
        UPDATE products 
        SET 
            products_name = ?,
            categories_id = ?,
            price = ?
        WHERE products_id = ?
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sidi",
        $products_name,
        $categories_id,
        $price,
        $product_id
    );


    if ($stmt->execute()) {

        header("Location: products.php");
        exit;

    } else {

        echo "Error updating product: " . $stmt->error;
    }
}

?>