<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require ('conn.php');
$sql="select * from users";
//run query
$result=$conn->query($sql);
//fetch all data
$users=$result->fetch_all(MYSQLI_ASSOC);
// var_dump($users);exit;


?>
<?php include("../common/head.php") ?>

<body>

<!-- hyde modal jbta mtl tb3 l category -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="insert_users.php" method="POST">
                    <div class="mb-3">
                        <label for="userName" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="userName" name="username" placeholder="Enter User name" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pass" name="password" placeholder="Enter Password" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                            <select class="form-control" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>

                        
                    </div>
                       

                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

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


                 <div class="container-fluid pt-4">
                <div class="row g-4 min-vh-100 rounded justify-content-center mx-0">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="container">
                                <div class="row justify-content-end mt-3">
                                    <div class="col-auto">
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                                Add Users
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-light rounded h-100 p-4">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="datatable">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>User Name</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user) { ?>

                                                <tr>
                                                                                        <!-- hsb database -->
                                                    <td><?php echo htmlspecialchars($user['usersname']) ?></td>
                                                    <td><?php echo htmlspecialchars($user['role']) ?></td>
                          
                                                  <td>
            <!-- hyde tb3 delete w update lal user eza bdna update model mtl ma 3mlna bl javascript -->
              <a href="delete_user.php?id=<?php echo $user['users_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')" title="delete">Delete</a>
       <a href="update_form_user.php?id=<?php echo $user['users_id'] ?>" class="btn btn-success btn-sm" title="edit">Edit</a>
    <a href="update_password.php?id=<?php echo $user['users_id']; ?>"class="btn btn-warning btn-sm" title="Change Password">
                                                            <i class="bi bi-key"></i> </a>

                                                        
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