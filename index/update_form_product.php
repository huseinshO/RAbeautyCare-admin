<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include('conn.php');
if (isset($_GET['prod_id'])) {
    $products_id = $_GET['prod_id'];
    $sql = "SELECT * FROM `products` INNER join categories on products.categories_id=categories.categories_id where products_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $products_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // var_dump($result);exit;
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();//fetch_assoc krml btrj3le one row le bde yee
        // var_dump($product);exit;
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Product ID not provided.";
    exit;
}


$categories_sql = "SELECT categories_id, categories_name FROM categories ORDER BY categories_name ASC ";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);//btrj3le kl lrows bshakel associated array



?>
<?php include("../common/head.php") ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php require("../common/sidebar.php") ?>

        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require("../common/navbar.php") ?>
            <!-- Navbar End -->


            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <form action="update_product.php" method="POST"  enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="prod_id" class="form-label" hidden>Product ID</label>
                                <input type="text" class="form-control" id="prod_id" name="prod_id" required value="<?php echo htmlspecialchars($product['products_id']); ?>" readonly hidden>
                            </div>
                            <div class="mb-3">
                                <label for="prod_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="prod_name" name="prod_name" required value="<?php echo htmlspecialchars($product['products_name']); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"> Category Name </label>
                                <select class="form-control" name="categories_id" required>
                                    <option value=""> Select Category </option>
                                    <?php foreach ($categories as $c) { ?>
                                        <option value="<?php echo $c['categories_id']; ?>" <?php if ($c['categories_id'] == $product['categories_id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($c['categories_name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="des" class="form-label">Description</label>
                            </div> -->
                            <div class="mb-3"> 
                                <label class="form-label"> Price </label>
                                 <input type="number" step="0.01" min="0" class="form-control" name="price" value="<?php echo $product['price']; ?>" required> 
                                </div>
<!-- hk zdna l image 3al update y3ne sar fena n3adela -->
                            <?php if (!empty($product['products_image'])) { ?>
                                <div class="mb-3">
                                    <label class="form-label"> Current Product Image </label>
                                    <br> <img src="../uploads/products/<?php echo htmlspecialchars($product['products_image']); ?>" 
                                    alt="Product Image" width="120" height="120" style="object-fit: cover;">
                                </div>
                            <?php } ?>

                            <div class="mb-3">
                                <label class="form-label"> Replace Product Image </label>
                                <input type="file" class="form-control" name="products_image" accept="image/*">
                            </div>


                            <button type="submit" class="btn btn-primary">Update Product</button>

                        </form>
                    </div>
                </div>
            </div>




            <!-- Footer Start -->
            <?php require("../common/footer.php") ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php require("../common/script.php") ?>

</body>

</html>