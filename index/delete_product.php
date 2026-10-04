<?php include('conn.php');

if (isset($_GET['product_id'])) {
    $product_id = (int) $_GET['product_id'];
    // var_dump($product_id); exit;// Debugging line to check the value of $product_id
  
    $sql = "DELETE FROM products WHERE products_id = ? ";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: products.php");
        exit;
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
} else {
    die("Product ID not provided.");
}
?>