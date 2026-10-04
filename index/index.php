<?php
//access control: eza luser ma 3ml login w 7awel yft7 ay page bl admin y3ml redirect 3ala el login page
session_start();
//eza mafe user_id bl session y3ne mesh 3amel login 
//fa eza bdo yktb lurl ma ha yfwto 3ala ay page bl admin w y3ml redirect 3ala el login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("conn.php");
include("../common/head.php");




// Count Categories

$sql_categories = "SELECT COUNT(*) AS total_categories FROM categories";

$result_categories = $conn->query($sql_categories);

$row_categories = $result_categories->fetch_assoc();

$total_categories = $row_categories['total_categories'];


// Count Products
$sql_products = "SELECT COUNT(*) AS total_products FROM products";

$result_products = $conn->query($sql_products);

$row_products = $result_products->fetch_assoc();

$total_products = $row_products['total_products'];



// Count Users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";

$result_users = $conn->query($sql_users);

$row_users = $result_users->fetch_assoc();

$total_users = $row_users['total_users'];



// Products Count By Category
$sql_category_products = "
 SELECT categories.categories_name,
        COUNT(products.products_id) AS total_products
    FROM categories
    LEFT JOIN products
        ON categories.categories_id = products.categories_id
    GROUP BY 
        categories.categories_id,
        categories.categories_name
";

$result_category_products = $conn->query($sql_category_products);


// Convert result to Array
$category_data = $result_category_products->fetch_all(MYSQLI_ASSOC);
//var_dump($category_data);exit; // Debugging line to check the fetched data


// Prepare Data For Pie Chart
$category_names = [];

$category_product_counts = [];


foreach ($category_data as $category) {

    $category_names[] = $category['categories_name'];

    $category_product_counts[] = $category['total_products'];
}

?>

<body>

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


        <!-- Sidebar Start -->

        <?php require("../common/sidebar.php"); ?>

        <!-- Sidebar End -->


        <!-- Content Start -->

        <div class="content">


            <!-- Navbar Start -->

            <?php require("../common/navbar.php"); ?>

            <!-- Navbar End -->


            <!-- Dashboard Content Start -->

            <div class="container-fluid pt-4 px-4">


                <!-- ==========================================
                 Dashboard Cards
            =========================================== -->

                <div class="row g-4">


                    <!-- Categories Card -->

                    <div class="col-sm-6 col-xl-4">

                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">

                            <i class="fa fa-list fa-3x text-primary"></i>

                            <div class="ms-3">

                                <p class="mb-2">
                                    Total Categories
                                </p>

                                <h6 class="mb-0">

                                    <?php echo $total_categories; ?>

                                </h6>

                            </div>

                        </div>

                    </div>


                    <!-- Products Card -->

                    <div class="col-sm-6 col-xl-4">

                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">

                            <i class="fa fa-box fa-3x text-success"></i>

                            <div class="ms-3">

                                <p class="mb-2">
                                    Total Products
                                </p>

                                <h6 class="mb-0">

                                    <?php echo $total_products; ?>

                                </h6>

                            </div>

                        </div>

                    </div>


                    <!-- Users Card -->

                    <div class="col-sm-6 col-xl-4">

                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">

                            <i class="fa fa-users fa-3x text-warning"></i>

                            <div class="ms-3">

                                <p class="mb-2">
                                    Total Users
                                </p>

                                <h6 class="mb-0">

                                    <?php echo $total_users; ?>

                                </h6>

                            </div>

                        </div>

                    </div>


                </div>


                <!-- ==========================================
                 Pie Chart
            =========================================== -->

                <div class="row g-4 mt-1">


                    <div class="col-12 col-xl-6">


                        <div class="bg-light rounded p-4">


                            <div class="d-flex align-items-center justify-content-between mb-4">

                                <h6 class="mb-0">
                                    Products by Category
                                </h6>

                            </div>


                            <canvas id="categoryProductsChart"></canvas>


                        </div>


                    </div>


                </div>


            </div>

            <!-- Dashboard Content End -->


            <!-- Footer Start -->

            <?php require("../common/footer.php"); ?>

            <!-- Footer End -->


        </div>

        <!-- Content End -->


        <!-- Back to Top -->

        <a href="#"
            class="btn btn-lg btn-primary btn-lg-square back-to-top">

            <i class="bi bi-arrow-up"></i>

        </a>


    </div>


    <!-- JavaScript Libraries -->

    <?php require("../common/script.php"); ?>


     Pie Chart JavaScript


   <script>
    // Get category names from PHP
    const categoryNames =
        <?php echo json_encode($category_names); ?>;

    // Get product counts from PHP
    const categoryProductCounts =
        <?php echo json_encode($category_product_counts); ?>;

    // Get the canvas element
    const categoryProductsChart =
        document.getElementById('categoryProductsChart');

    // Create the Products by Category Pie Chart
    new Chart(categoryProductsChart, {

        type: 'pie',

        data: {
            labels: categoryNames,

            datasets: [{
                label: 'Products',

                data: categoryProductCounts,

                // Colors for each category
                backgroundColor: [
                    '#F43F8C',
                    '#FF8FB8',
                    '#F9A8D4',
                    '#E879A9',
                    '#FDA4AF',
                    '#FBCFE8',
                    '#EC4899'
                ],

                // Border color between slices
                borderColor: '#ffffff',

                // Border thickness
                borderWidth: 2
            }]
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }

    });
</script>


</body>

</html>