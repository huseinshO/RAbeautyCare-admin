<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include("conn.php");

// hon mnجيب kel l services mn database
$sql = "SELECT service_id, service_name, description, icon, is_active
        FROM services
        ORDER BY service_id ASC";

$result = $conn->query($sql);

if (!$result) {
    die("DATABASE QUERY ERROR: " . $conn->error);
}

// hon mn7awwel l result la array
$services = $result->fetch_all(MYSQLI_ASSOC);

?>

<?php include("../common/head.php"); ?>

<body>

    <!-- Add Service Modal Start -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Service
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <form action="insert_services.php" method="POST">

                    <div class="modal-body">

                        <!-- Service Name -->
                        <div class="mb-3">

                            <label class="form-label">
                                Service Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="service_name"
                                   placeholder="Enter service name"
                                   required>

                        </div>


                        <!-- Description -->
                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea class="form-control"
                                      name="description"
                                      rows="4"
                                      placeholder="Enter service description"
                                      required></textarea>

                        </div>


                        <!-- Icon -->
                        <div class="mb-3">

                            <label class="form-label">
                                Icon
                            </label>

                            <!-- hon user by7ot esm Font Awesome icon -->
                            <input type="text"
                                   class="form-control"
                                   name="icon"
                                   placeholder="Example: fa fa-heartbeat">

                            <small class="text-muted">
                                Example: fa fa-heartbeat
                            </small>

                        </div>


                        <!-- Active -->
                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select class="form-select"
                                    name="is_active"
                                    required>

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-primary">

                            Add Service

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Add Service Modal End -->


    <!-- Edit Service Modal Start -->
    <div class="modal fade" id="editServiceModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Service
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <form action="update_services.php" method="POST">

                    <div class="modal-body">

                        <!-- hon mnخزن ID taba3 l service -->
                        <input type="hidden"
                               name="service_id"
                               id="edit_service_id">


                        <!-- Service Name -->
                        <div class="mb-3">

                            <label class="form-label">
                                Service Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="service_name"
                                   id="edit_service_name"
                                   required>

                        </div>


                        <!-- Description -->
                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea class="form-control"
                                      name="description"
                                      id="edit_description"
                                      rows="4"
                                      required></textarea>

                        </div>


                        <!-- Icon -->
                        <div class="mb-3">

                            <label class="form-label">
                                Icon
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="icon"
                                   id="edit_icon"
                                   placeholder="Example: fa fa-heartbeat">

                        </div>


                        <!-- Status -->
                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select class="form-select"
                                    name="is_active"
                                    id="edit_is_active"
                                    required>

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-primary">

                            Update Service

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- Edit Service Modal End -->


    <!-- Main Container Start -->
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


            <!-- Services Content Start -->
            <div class="container-fluid pt-4">

                <div class="row g-4 min-vh-100 rounded justify-content-center mx-0">

                    <div class="col-12">

                        <div class="bg-light rounded h-100 p-4">

                            <!-- Add Button -->
                            <div class="text-end mb-3">

                                <button type="button"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addServiceModal">

                                    Add Service

                                </button>

                            </div>


                            <!-- Services Table -->
                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover">

                                    <thead>

                                        <tr class="table-primary">

                                            <th>
                                                ID
                                            </th>

                                            <th>
                                                Service Name
                                            </th>

                                            <th>
                                                Description
                                            </th>

                                            <th>
                                                Icon
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Actions
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        <?php if (!empty($services)): ?>

                                            <?php foreach ($services as $service): ?>

                                                <tr>

                                                    <td>
                                                        <?php echo (int)$service['service_id']; ?>
                                                    </td>


                                                    <td>
                                                        <?php echo htmlspecialchars($service['service_name']); ?>
                                                    </td>


                                                    <td>
                                                        <?php echo htmlspecialchars($service['description']); ?>
                                                    </td>


                                                    <td>

                                                        <i class="<?php echo htmlspecialchars($service['icon'] ?: 'fa fa-star'); ?>"></i>

                                                        <?php echo htmlspecialchars($service['icon'] ?: 'fa fa-star'); ?>

                                                    </td>


                                                    <td>

                                                        <?php if ((int)$service['is_active'] === 1): ?>

                                                            <span class="badge bg-success">
                                                                Active
                                                            </span>

                                                        <?php else: ?>

                                                            <span class="badge bg-secondary">
                                                                Inactive
                                                            </span>

                                                        <?php endif; ?>

                                                    </td>


                                                    <td>

                                                        <!-- Edit Button -->
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-success edit-service-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editServiceModal"
                                                                data-id="<?php echo (int)$service['service_id']; ?>"
                                                                data-name="<?php echo htmlspecialchars($service['service_name'], ENT_QUOTES); ?>"
                                                                data-description="<?php echo htmlspecialchars($service['description'], ENT_QUOTES); ?>"
                                                                data-icon="<?php echo htmlspecialchars($service['icon'] ?? '', ENT_QUOTES); ?>"
                                                                data-active="<?php echo (int)$service['is_active']; ?>">

                                                            Edit

                                                        </button>


                                                        <!-- Delete Button -->
                                                        <a href="delete_services.php?service_id=<?php echo (int)$service['service_id']; ?>"
                                                           class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Are you sure you want to delete this service?');">

                                                            Delete

                                                        </a>

                                                    </td>

                                                </tr>

                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <tr>

                                                <td colspan="6"
                                                    class="text-center">

                                                    No Services Found.

                                                </td>

                                            </tr>

                                        <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>
                            <!-- Services Table End -->

                        </div>

                    </div>

                </div>

            </div>
            <!-- Services Content End -->


            <!-- Footer Start -->
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
    <!-- Main Container End -->


    <!-- JavaScript Start -->
    <?php require("../common/script.php"); ?>

    <script>

        // hon mn3abbe data taba3 l service bel Edit Modal
        document.querySelectorAll('.edit-service-btn').forEach(function(button) {

            button.addEventListener('click', function() {

                // mnجيب data mn button
                document.getElementById('edit_service_id').value =
                    this.getAttribute('data-id');

                document.getElementById('edit_service_name').value =
                    this.getAttribute('data-name');

                document.getElementById('edit_description').value =
                    this.getAttribute('data-description');

                document.getElementById('edit_icon').value =
                    this.getAttribute('data-icon');

                document.getElementById('edit_is_active').value =
                    this.getAttribute('data-active');

            });

        });

    </script>

</body>

</html>
