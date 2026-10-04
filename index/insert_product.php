<?php
include('conn.php');
// var_dump($_FILES);exit;
// echo '<pre>'; print_r($_FILES); echo '</pre>'; exit;
// $file_name=$_FILES['products_image']['type']; //by3tena type le ela hsb ane sho bht bde , name , type,size
// var_dump($file_name);exit;//w bn3ml vardump lnshof sho by3tena 
if (isset($_FILES['products_image']) && $_FILES['products_image']['error'] === UPLOAD_ERR_OK) {
    if (isset($_POST['products_name']) && isset($_POST['categories_id']) && isset($_POST['price'])) { //hsb esmon bl form
        $original_name = $_FILES['products_image']['name']; //[name] hk by3tene esma lal imag
        $tmp_name = $_FILES['products_image']['tmp_name']; //hk jbna temaperary file
        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION)); //strtolower bthwla la small, 
        //pathinfo_extension btl3le bs extension le ela y3ne e.g:jpg,png,..
        // var_dump($extension);exit;
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp']; //hk bnhaded l extension le bdna yehon  8er l extension le hateton ma b5ale yht 
        if (!in_array($extension, $allowed_extensions)) {
            die("Invalid image format.");
        } // maa lfow2a
        $max_size = 2 * 1024 * 1024; //hyde bnhaded size le ela
        if ($_FILES['products_image']['size'] > $max_size) {
            die("Image size must not exceed 2 MB.");
        } //w bn3ml check mn 5elel if/else
        //generate inuq filename
        $file_name = uniqid('product_', true) . '.' . $extension; //bn3mla krml eza htyna nfs l imag ma y3ml replace lale abl, 
        //whyde le b3mla insert 3a database
        // var_dump($file_name);exit;
        $upload_folder = '../uploads/products/'; //esm lfolder le 3mlnelo create
        $destination = $upload_folder . $file_name; //hyde destination
        if (move_uploaded_file($tmp_name, $destination)) { //krml y5d l imag mn temprery w hota bl destination le hwe lfolder le 3mlne
            // Image successfully moved 
        } else {
            die("Failed to upload image.");
        }


        $products_name = trim($_POST['products_name']);
        $categories_id = (int) $_POST['categories_id'];
        $price = (float) $_POST['price'];

        if ($products_name === '') {
            die("Product name is required.");
        }
        if ($categories_id <= 0) {
            die("Please select a category.");
        }
        if ($price < 0) {
            die("Invalid product price.");
        }


        $sql = "INSERT INTO `products`(`products_name`, `categories_id`, `price`, `products_image`) VALUES (?, ?, ?, ?) ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sids", $products_name, $categories_id, $price, $file_name); //hsb lfo2 tb3 l uniq bktba
        if ($stmt->execute()) {
            header("Location: products.php");
            exit;
        } else {
            echo "Error adding product: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "Error uploading file: " . $_FILES['products_image']['error'];
}
