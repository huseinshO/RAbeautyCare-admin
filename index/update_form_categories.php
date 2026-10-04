<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include('conn.php');
if(isset($_GET['cat_id'])) { //nhna smyneha cat_id bl href 
    $categories_id = $_GET['cat_id'];
    $sql = "SELECT * FROM categories WHERE categories_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categories_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // var_dump($result);exit;
    if ($result->num_rows > 0) {
        // $category = $result->fetch_all(MYSQLI_ASSOC);
        $category = $result->fetch_assoc();//laan la one row
        // var_dump($category);exit;
    } else {
        echo "Category not found.";
        exit;
    }
} else {
    echo "Category ID not provided.";
    exit;
}



?>
<!-- copy past la file index.php w bnzed aale w bnzbt -->
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


            <!-- zdna form -->
              <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                      <form action="update_category.php" method="POST">

                       <div class="mb-3">
                        <!-- 3mlt hidden lal id -->
          <label for="cat_id" class="form-label" hidden>Category ID</label>
          <input type="text" class="form-control" id="cat_id" name="cat_id" required value="<?php echo htmlspecialchars($category['categories_id']); ?>" readonly hidden>
                        </div>
                        <div class="mb-3">
                            <label for="cat_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="cat_name" name="cat_name" required value="<?php echo htmlspecialchars($category['categories_name']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="des" class="form-label">Description</label>
                            <textarea class="form-control" id="des" name="des" rows="3" required><?php echo htmlspecialchars($category['description']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Category</button>

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