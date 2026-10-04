<?php
session_start();

// krml nمنع ay 7ada yfot 3a products.php bala login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("conn.php");


// ==================================================
// Get All Categories
// ==================================================

$sql = "SELECT * FROM `categories`";

$result = $conn->query($sql);

$categories = $result->fetch_all(MYSQLI_ASSOC);

// var_dump($categories);exit;


// ==================================================
// Get All Products
// ==================================================
// LEFT JOIN krml nجيب kel products
// hata law category taba3 l product ma 3enda match
// ma n5ale l product تختفي mn l table

$sql1 = "SELECT *
         FROM `products`
         LEFT JOIN categories
         ON products.categories_id = categories.categories_id";

$result1 = $conn->query($sql1);

$products = $result1->fetch_all(MYSQLI_ASSOC);

// var_dump($products);exit;

?>

<?php include("../common/head.php") ?>

<body>

    <!-- ==================================================
         Add Product Modal
    ================================================== -->

    <div class="modal fade"
        id="addProductModal"
        tabindex="-1"
        aria-labelledby="addProductModalLabel"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="addProductModalLabel">
                        Add Product
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <!--
                        lzm n7ot enctype multipart/form-data
                        krml n2dar nرفع product image
                    -->

                    <form action="insert_product.php"
                        method="POST"
                        enctype="multipart/form-data">


                        <!-- Product Name -->

                        <div class="mb-3">

                            <label for="products_name"
                                class="form-label">

                                Product Name

                            </label>

                            <input type="text"
                                class="form-control"
                                id="products_name"
                                name="products_name"
                                required>

                        </div>


                        <!-- Category -->

                        <div class="mb-3">

                            <label for="categories_id"
                                class="form-label">

                                Category Name

                            </label>

                            <select class="form-control"
                                id="categories_id"
                                name="categories_id"
                                required>

                                <option value="">
                                    Select Category
                                </option>


                                <?php foreach ($categories as $c) { ?>

                                    <option value="<?php echo $c['categories_id']; ?>">

                                        <?php
                                        echo htmlspecialchars(
                                            $c['categories_name']
                                        );
                                        ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- Price -->

                        <div class="mb-3">

                            <label for="price"
                                class="form-label">

                                Price

                            </label>

                            <input type="number"
                                step="0.01"
                                min="0"
                                class="form-control"
                                id="price"
                                name="price"
                                required>

                        </div>


                        <!-- Product Image -->

                        <div class="mb-3">

                            <label for="products_image"
                                class="form-label">

                                Product Image

                            </label>

                            <input type="file"
                                class="form-control"
                                id="products_image"
                                name="products_image"
                                accept="image/*"
                                required>

                        </div>


                        <!-- Add Button -->

                        <button type="submit"
                            class="btn btn-primary">

                            Add Product

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- ==================================================
         Main Container
    ================================================== -->

    <div class="container-fluid position-relative bg-white d-flex p-0">


        <!-- Spinner Start -->

        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">

            <div class="spinner-border text-primary"
                style="width: 3rem; height: 3rem;"
                role="status">

                <span class="sr-only">
                    Loading...
                </span>

            </div>

        </div>

        <!-- Spinner End -->


        <!-- ==================================================
             Sidebar Start
        ================================================== -->

        <?php require("../common/sidebar.php") ?>

        <!-- Sidebar End -->


        <!-- ==================================================
             Content Start
        ================================================== -->

        <div class="content">


            <!-- Navbar Start -->

            <?php require("../common/navbar.php") ?>

            <!-- Navbar End -->


            <!-- ==================================================
                 Products Content
            ================================================== -->

            <div class="container-fluid pt-4">

                <div class="row g-4 min-vh-100 rounded justify-content-center mx-0">

                    <div class="col-12">

                        <div class="bg-light rounded h-100 p-4">


                            <!-- Add Product Button -->

                            <div class="container">

                                <div class="row justify-content-end mt-3">

                                    <div class="col-auto">

                                        <button type="button"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addProductModal">

                                            Add Products

                                        </button>

                                    </div>

                                </div>

                            </div>


                            <!-- ==================================================
                                 Products Table
                            ================================================== -->

                            <div class="bg-light rounded h-100 p-4">

                                <div class="table-responsive">

                                    <table class="table table-striped table-bordered table-hover"
                                        id="datatable">


                                        <!-- Table Header -->

                                        <thead>

                                            <tr class="table-primary">

                                                <th>
                                                    Product Name
                                                </th>

                                                <th>
                                                    Category Name
                                                </th>

                                                <th>
                                                    Price
                                                </th>

                                                <th>
                                                    Product Image
                                                </th>

                                                <th>
                                                    Actions
                                                </th>

                                            </tr>

                                        </thead>


                                        <!-- Table Body -->

                                        <tbody>


                                            <?php foreach ($products as $product) { ?>

                                                <tr>


                                                    <!-- Product Name -->

                                                    <td>

                                                        <?php
                                                        echo htmlspecialchars(
                                                            $product['products_name']
                                                        );
                                                        ?>

                                                    </td>


                                                    <!-- Category Name -->

                                                    <td>

                                                        <?php

                                                        // iza l category mawjoude
                                                        // nbayyen esma

                                                        if (!empty($product['categories_name'])) {

                                                            echo htmlspecialchars(
                                                                $product['categories_name']
                                                            );
                                                        } else {

                                                            // iza ma fi category match
                                                            // nbayyen No Category

                                                            echo "No Category";
                                                        }

                                                        ?>

                                                    </td>


                                                    <!-- Price -->

                                                    <td>

                                                        <?php
                                                        echo htmlspecialchars(
                                                            $product['price']
                                                        );
                                                        ?>

                                                    </td>


                                                    <!-- Product Image -->

                                                    <td>

                                                        <?php if (!empty($product['products_image'])) { ?>

                                                            <img
                                                                src="../uploads/products/<?php echo htmlspecialchars($product['products_image']); ?>"
                                                                alt="<?php echo htmlspecialchars($product['products_name']); ?>"
                                                                width="100"
                                                                height="100"
                                                                style="object-fit: cover; border-radius: 10px;">

                                                        <?php } else { ?>

                                                            No Image

                                                        <?php } ?>

                                                    </td>


                                                    <!-- Actions -->

                                                    <td>


                                                        <!--
                                                            Edit Product
                                                            bnba3at products_id
                                                            la update_form_product.php
                                                        -->

                                                        <a
                                                            href="update_form_product.php?prod_id=<?php echo $product['products_id']; ?>"
                                                            class="btn btn-sm btn-outline-success">

                                                            Edit

                                                        </a>


                                                        <!--
                                                            Delete Product
                                                            bnba3at products_id
                                                            la delete_product.php
                                                        -->

                                                        <a
                                                            href="delete_product.php?product_id=<?php echo $product['products_id']; ?>"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure you want to delete this product?');">

                                                            Delete

                                                        </a>


                                                    </td>

                                                </tr>


                                            <?php } ?>


                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==================================================
                 Footer Start
            ================================================== -->

            <?php require("../common/footer.php") ?>

            <!-- Footer End -->


        </div>

        <!-- Content End -->


        <!-- ==================================================
             Back To Top
        ================================================== -->

        <a href="#"
            class="btn btn-lg btn-primary btn-lg-square back-to-top">

            <i class="bi bi-arrow-up"></i>

        </a>


    </div>


    <!-- ==================================================
         JavaScript Libraries
    ================================================== -->

    <?php require("../common/script.php") ?>


</body>

</html>