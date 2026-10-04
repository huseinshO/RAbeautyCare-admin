<?php

session_start();


// ==================================================
// Check Login
// ==================================================

// krml ma yfot 3a page change password bala login

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;

}


// ==================================================
// Connect To Database
// ==================================================

include("conn.php");


// ==================================================
// Get User ID
// ==================================================

// mn users.php bnba3at users_id 3a URL

if (!isset($_GET['id'])) {

    header("Location: users.php");
    exit;

}

$id = (int) $_GET['id'];


// ==================================================
// Get Selected User
// ==================================================

$sql = "SELECT * FROM users WHERE users_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();


// iza l user mawjoud

if ($result->num_rows == 0) {

    die("User not found.");

}

$user = $result->fetch_assoc();


// ==================================================
// Update Password
// ==================================================

$error = "";

$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // njib l password mn l form

    $password = $_POST['password'];

    $confirm_password = $_POST['confirm_password'];


    // ==================================================
    // Check Password Confirmation
    // ==================================================

    // krml nt2aked enno l passwords nfs shi

    if ($password !== $confirm_password) {

        $error = "Passwords do not match.";

    }


    // ==================================================
    // Check Password Length
    // ==================================================

    elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters.";

    }


    else {


        // ==================================================
        // Hash Password
        // ==================================================

        // ma mn5azen l password plain text
        // password_hash by7awela la hashed password

        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );


        // ==================================================
        // Update Password
        // ==================================================

        $update_sql = "
            UPDATE users
            SET password = ?
            WHERE users_id = ?
        ";

        $update_stmt = $conn->prepare($update_sql);

        $update_stmt->bind_param(
            "si",
            $hashed_password,
            $id
        );


        if ($update_stmt->execute()) {

            // password updated successfully

            echo "
                <script>
                    alert('Password updated successfully!');
                    window.location.href='users.php';
                </script>
            ";

            exit;

        } else {

            $error = "Error updating password.";

        }


        $update_stmt->close();

    }

}

?>

<?php include("../common/head.php"); ?>


<body>


<div class="container-fluid position-relative bg-white d-flex p-0">


    <!-- ==================================================
         Spinner Start
    ================================================== -->

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

    <?php require("../common/sidebar.php"); ?>

    <!-- Sidebar End -->


    <!-- ==================================================
         Content Start
    ================================================== -->

    <div class="content">


        <!-- Navbar Start -->

        <?php require("../common/navbar.php"); ?>

        <!-- Navbar End -->


        <!-- ==================================================
             Change Password Content
        ================================================== -->

        <div class="container-fluid pt-4 px-4">


            <div class="row justify-content-center">


                <div class="col-md-8 col-lg-6">


                    <div class="bg-light rounded p-4">


                        <!-- Page Title -->

                        <div class="mb-4">

                            <h4 class="mb-1">

                                <i class="bi bi-key me-2"></i>

                                Change Password

                            </h4>

                            <p class="text-muted mb-0">

                                Change password for the selected user.

                            </p>

                        </div>


                        <!-- ==================================================
                             Show Error
                        ================================================== -->

                        <?php if (!empty($error)) { ?>

                            <div class="alert alert-danger">

                                <?php echo htmlspecialchars($error); ?>

                            </div>

                        <?php } ?>


                        <!-- ==================================================
                             Username
                        ================================================== -->

                        <div class="mb-3">

                            <label class="form-label">

                                Username

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="<?php echo htmlspecialchars($user['usersname']); ?>"
                                disabled
                            >

                        </div>


                        <!-- ==================================================
                             Change Password Form
                        ================================================== -->

                        <form method="POST">


                            <!-- New Password -->

                            <div class="mb-3">

                                <label for="password"
                                       class="form-label">

                                    New Password

                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    required
                                    minlength="6"
                                    autocomplete="new-password"
                                >

                            </div>


                            <!-- Confirm Password -->

                            <div class="mb-3">

                                <label for="confirm_password"
                                       class="form-label">

                                    Confirm New Password

                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="confirm_password"
                                    name="confirm_password"
                                    required
                                    minlength="6"
                                    autocomplete="new-password"
                                >

                            </div>


                            <!-- ==================================================
                                 Buttons
                            ================================================== -->

                            <div class="d-flex gap-2">


                                <!-- Update Password -->

                                <button
                                    type="submit"
                                    class="btn btn-primary">

                                    <i class="bi bi-key me-1"></i>

                                    Update Password

                                </button>


                                <!-- Cancel -->

                                <a
                                    href="users.php"
                                    class="btn btn-secondary">

                                    Cancel

                                </a>


                            </div>


                        </form>


                    </div>

                </div>

            </div>

        </div>


        <!-- ==================================================
             Footer Start
        ================================================== -->

        <?php require("../common/footer.php"); ?>

        <!-- Footer End -->


    </div>

    <!-- Content End -->


    <!-- Back To Top -->

    <a href="#"
       class="btn btn-lg btn-primary btn-lg-square back-to-top">

        <i class="bi bi-arrow-up"></i>

    </a>


</div>


<!-- ==================================================
     JavaScript
================================================== -->

<?php require("../common/script.php"); ?>


</body>

</html>