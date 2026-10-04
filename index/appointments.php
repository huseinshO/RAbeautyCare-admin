<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("conn.php");

$sql = "SELECT * FROM appointments
        ORDER BY appointment_date ASC, appointment_time ASC";

$result = $conn->query($sql);

$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php include("../common/head.php") ?>

<body>

    <div class="container-fluid position-relative bg-white d-flex p-0">

        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">

            <div class="spinner-border text-primary"
                style="width: 3rem; height: 3rem;"
                role="status">

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

                            <h6 class="mb-4">
                                Appointments
                            </h6>

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover">

                                    <thead>

                                        <tr class="table-primary">

                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Service</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Notes</th>
                                            <th>Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($appointments as $appointment) { ?>

                                            <tr>

                                                <td>
                                                    <?php
                                                    echo $appointment['appointment_id'];
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $appointment['customer_name']
                                                    );
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $appointment['phone']
                                                    );
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $appointment['service']
                                                    );
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $appointment['appointment_date']
                                                    );
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $appointment['appointment_time']
                                                    );
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $appointment['notes'] ?? ''
                                                    );
                                                    ?>
                                                </td>

                                                <td>

                                                    <!-- <a
                                                        href="update_form_appointment.php?appointment_id=<?php echo $appointment['appointment_id']; ?>"
                                                        class="btn btn-sm btn-outline-success">
                                                        Edit
                                                    </a> -->

                                                    <a
                                                        href="delete_appointment.php?appointment_id=<?php echo $appointment['appointment_id']; ?>"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this appointment?');">
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


            <!-- Footer Start -->
            <?php require("../common/footer.php") ?>
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
    <?php require("../common/script.php") ?>

</body>

</html>