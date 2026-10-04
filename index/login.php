<?php  session_start(); //session start dymn awal line bl page ,heye krml n3rf eza 3amel login wla la2

if($_POST){
    // var_dump($_POST);exit;
    include("conn.php");
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);
    $sql = "SELECT * FROM users WHERE usersname = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();//y3ne nafez el query 3ala el database
$result = $stmt->get_result();

if ($result->num_rows > 0) {//eza luser mwjod

    $user = $result->fetch_assoc(); //jble el user mn el database w7to bl array w heye 1 row laan assoc

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['users_id'];
        $_SESSION['username'] = $user['usersname'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php");//bfwtne 3ala el index.php eza luser mwjod w password s7e7
        exit;

    } else {

        echo "Invalid password.";

    }

} else {

    echo "User not found.";

}

$stmt->close();
}
?>

 <!-- hyde 3mlt copy past lal signin.html w 8yrt feha -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../raweb/img/rowaida-logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.php" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>
                        
                        <form action="" method="POST">
                        <div class="form-floating mb-3">
                            <input type="username" class="form-control" id="floatingInput" name="username" required autocomplete="off">
                            <label for="floatingInput">Username</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required autocomplete="off">
                            <label for="floatingPassword">Password</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Login</button>
                        <!-- <p class="text-center mb-0">Don't have an Account? <a href="">Sign Up</a></p> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>