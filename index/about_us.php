<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include("conn.php");

// hon mnجيب data taba3 About Us mn database
$sql = "SELECT * FROM about_us ORDER BY about_id ASC LIMIT 1";

$result = $conn->query($sql);

if (!$result) {
    die("DATABASE QUERY ERROR: " . $conn->error);
}

// hon mnجيب row wa7de la2an About Us 3anna section wa7de
$about = $result->fetch_assoc();

?>

<?php include("../common/head.php"); ?>

<body>

    <!-- Add About Us Modal -->
    <div class="modal fade"
         id="addAboutModal"
         tabindex="-1"
         aria-labelledby="addAboutModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="addAboutModalLabel">
                        Add About Us
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>

                <div class="modal-body">

                    <form action="insert_about_us.php"
                          method="POST"
                          enctype="multipart/form-data">

                        <div class="mb-3">

                            <label class="form-label">
                                Title
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="title"
                                   placeholder="Enter title"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Text One
                            </label>

                            <textarea class="form-control"
                                      name="text_one"
                                      rows="4"
                                      placeholder="Enter first text"
                                      required></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Text Two
                            </label>

                            <textarea class="form-control"
                                      name="text_two"
                                      rows="4"
                                      placeholder="Enter second text"
                                      required></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Image One
                            </label>

                            <input type="file"
                                   class="form-control"
                                   name="image_one"
                                   accept="image/*"
                                   required>

                        </div>
<button type="submit"
                                class="btn btn-primary float-end">

                            Submit

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>
    <!-- End Add About Us Modal -->


    <!-- Edit About Us Modal -->

    <div class="modal fade"
         id="editAboutModal"
         tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit About Us
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>


                <form action="update_about_us.php"
                      method="POST"
                      enctype="multipart/form-data">

                    <div class="modal-body">

                        <!-- hon mnخزن ID taba3 About Us -->
                        <input type="hidden"
                               name="about_id"
                               value="<?php echo htmlspecialchars($about['about_id'] ?? ''); ?>">


                        <div class="mb-3">

                            <label class="form-label">
                                Title
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="title"
                                   value="<?php echo htmlspecialchars($about['title'] ?? ''); ?>"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Text One
                            </label>

                            <textarea class="form-control"
                                      name="text_one"
                                      rows="4"
                                      required><?php echo htmlspecialchars($about['text_one'] ?? ''); ?></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Text Two
                            </label>

                            <textarea class="form-control"
                                      name="text_two"
                                      rows="4"
                                      required><?php echo htmlspecialchars($about['text_two'] ?? ''); ?></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Current Image One
                            </label>

                            <?php if (!empty($about['image_one'])) { ?>

                                <!-- hon mn3ared l sora l2dime -->
                                <div class="mb-2">

                                    <img src="../uploads/about/<?php echo htmlspecialchars($about['image_one']); ?>"
                                         alt="About Image One"
                                         style="width:160px;height:120px;object-fit:cover;border-radius:8px;">

                                </div>

                            <?php } else { ?>

                                <p>No Image</p>

                            <?php } ?>

                            <label class="form-label">
                                Change Image One
                            </label>

                            <!-- eza ma 5tar sora jdide, l sora l2dime btضل -->
                            <input type="file"
                                   class="form-control"
                                   name="image_one"
                                   accept="image/*">

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

                            Update About Us

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- End Edit About Us Modal -->


    <!-- Main Container -->

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


            <!-- About Us Content -->

            <div class="container-fluid pt-4">

                <div class="row g-4 min-vh-100 rounded justify-content-center mx-0">

                    <div class="col-12">

                        <div class="bg-light rounded h-100 p-4">

                            <?php if (empty($about)) { ?>

                                <!-- eza ma fi About Us bl database, mnظهر Add button -->

                                <div class="text-end mb-3">

                                    <button type="button"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addAboutModal">

                                        Add About Us

                                    </button>

                                </div>

                            <?php } ?>


                            <!-- About Us Table -->

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover">

                                    <thead>

                                        <tr class="table-primary">

                                            <th>
                                                Image One
                                            </th>

                                            <th>
                                                Title
                                            </th>

                                            <th>
                                                Text One
                                            </th>

                                            <th>
                                                Text Two
                                            </th>

                                            <th>
                                                Actions
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        <?php if (!empty($about)) { ?>

                                            <tr>

                                                <!-- Image One -->

                                                <td>

                                                    <?php if (!empty($about['image_one'])) { ?>

                                                        <img
                                                            src="../uploads/about/<?php echo htmlspecialchars($about['image_one']); ?>"
                                                            alt="About Image One"
                                                            style="width:90px;height:70px;object-fit:cover;border-radius:8px;">

                                                    <?php } else { ?>

                                                        <span>
                                                            No Image
                                                        </span>

                                                    <?php } ?>

                                                </td>
<!-- Title -->

                                                <td>
                                                    <?php echo htmlspecialchars($about['title']); ?>
                                                </td>


                                                <!-- Text One -->

                                                <td>
                                                    <?php echo htmlspecialchars($about['text_one']); ?>
                                                </td>


                                                <!-- Text Two -->

                                                <td>
                                                    <?php echo htmlspecialchars($about['text_two']); ?>
                                                </td>
<!-- Actions -->

                                                <td>

                                                    <!-- Edit Button -->

                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAboutModal">

                                                        Edit

                                                    </button>


                                                    <!-- Delete Button -->

                                                    <a
                                                        href="delete_about_us.php?about_id=<?php echo $about['about_id']; ?>"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete About Us?');">

                                                        Delete

                                                    </a>

                                                </td>

                                            </tr>

                                        <?php } else { ?>

                                            <tr>

                                                <td colspan="4"
                                                    class="text-center">

                                                    No About Us data found.

                                                </td>

                                            </tr>

                                        <?php } ?>

                                    </tbody>

                                </table>

                            </div>

                            <!-- End About Us Table -->


                        </div>

                    </div>

                </div>

            </div>

            <!-- End About Us Content -->


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

    <!-- End Main Container -->


    <!-- JavaScript Libraries -->

    <?php require("../common/script.php"); ?>

</body>

</html>
