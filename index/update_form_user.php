<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include('conn.php');
if(isset($_GET['id'])) {
    $users_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $users_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // var_dump($result);exit;
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "User ID not provided.";
    exit;
}



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
                      <form action="update_user.php" method="POST">

                       <div class="mb-3">
                            <label for="user_id" class="form-label" hidden>User ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required value="<?php echo htmlspecialchars($user['users_id']); ?>" readonly hidden>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="username" name="username" required value="<?php echo htmlspecialchars($user['usersname']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <textarea class="form-control" id="role" name="role" rows="3" required><?php echo htmlspecialchars($user['role']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>

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