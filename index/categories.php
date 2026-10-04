<?php
//access control: eza luser ma 3ml login w 7awel yft7 ay page bl admin y3ml redirect 3ala el login page
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include("conn.php");

$sql = "SELECT * FROM categories";

$result = $conn->query($sql);

if (!$result) {
    die("DATABASE QUERY ERROR: " . $conn->error);
}

$categories = $result->fetch_all(MYSQLI_ASSOC);

?>

<?php include("../common/head.php"); ?>

<body>

    <!-- Add Category Modal -->
    <div class="modal fade"
         id="addCategoryModal"
         tabindex="-1"
         aria-labelledby="addCategoryModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="addCategoryModalLabel">
                        Add Category
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>

                <div class="modal-body">

                    <form action="insert_categories.php"
                          method="POST"
                          enctype="multipart/form-data">

                        <div class="mb-3">

                            <label for="categoryName" class="form-label">
                                Category Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="categoryName"
                                   name="cat_name"
                                   placeholder="Enter Category name"
                                   required
                                   autocomplete="off">

                        </div>


                        <div class="mb-3">

                            <label for="userId" class="form-label">
                                User Id
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="userId"
                                   name="user_id"
                                   value="<?php echo $user_id; ?>"
                                   readonly>

                        </div>


                        <div class="mb-3">

                            <label for="des" class="form-label">
                                Description
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="des"
                                   name="des"
                                   placeholder="Enter description"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label for="category_image" class="form-label">
                                Category Image
                            </label>

                            <input type="file"
                                   class="form-control"
                                   id="category_image"
                                   name="category_image"
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
    <!-- End Add Category Modal -->


    <!-- Edit Category Modal -->
    <div class="modal fade"
         id="editCategoryModal"
         tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Category
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>


                <form action="update_category.php"
                      method="POST"
                      enctype="multipart/form-data">

                    <input type="hidden"
                           name="user_id"
                           value="<?php echo $user_id; ?>">


                    <div class="modal-body">

                        <!-- 3mlna hidden lal category ID -->
                        <input type="hidden"
                               id="edit_cat_id"
                               name="cat_id">


                        <div class="mb-3">

                            <label class="form-label">
                                Category Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_cat_name"
                                   name="cat_name"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea class="form-control"
                                      id="edit_des"
                                      name="des"
                                      rows="3"
                                      required></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Current Image
                            </label>

                            <!-- hon mn3ared l sora l2dime -->
                            <div class="mb-2">

                                <img id="edit_category_image_preview"
                                     src=""
                                     alt="Current category"
                                     style="width:120px;height:90px;object-fit:cover;border-radius:8px;display:none;">

                            </div>


                            <!-- hon mnkhazen essem l sora l2dime -->
                            <input type="hidden"
                                   id="edit_current_image"
                                   name="current_image">


                            <label for="edit_category_image"
                                   class="form-label">

                                Change Image

                            </label>

                            <!-- hon l user fik yختار sora jdide -->
                            <input type="file"
                                   class="form-control"
                                   id="edit_category_image"
                                   name="category_image"
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

                            Update Category

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>
    <!-- End Edit Category Modal -->


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


            <!-- Categories Content -->

            <div class="container-fluid pt-4">

                <div class="row g-4 min-vh-100 rounded justify-content-center mx-0">

                    <div class="col-12">

                        <div class="bg-light rounded h-100 p-4">


                            <!-- Add Category Button -->

                            <div class="container">

                                <div class="row justify-content-end mt-3">

                                    <div class="col-auto">

                                        <button type="button"
                                                class="btn btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addCategoryModal">

                                            Add Categories

                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- End Add Category Button -->


                            <!-- Categories Table -->

                            <div class="bg-light rounded h-100 p-4">

                                <div class="table-responsive">

                                    <table class="table table-striped table-bordered table-hover"
                                           id="datatable">


                                        <thead>

                                            <tr class="table-primary">

                                                <!-- hon zedna column lal sora -->
                                                <th>
                                                    Category Image
                                                </th>

                                                <th>
                                                    Category Name
                                                </th>

                                                <th>
                                                    Description
                                                </th>

                                                <th>
                                                    Actions
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            <?php foreach ($categories as $category) { ?>

                                                <tr>

                                                    <!-- Category Image -->

                                                    <td>

                                                        <!-- hon mncheck eza fi sora lal category -->

                                                        <?php if (!empty($category['category_image'])) { ?>

                                                            <!-- hon mn3ared l sora mn uploads/categories -->

                                                            <img
                                                                src="../uploads/categories/<?php echo htmlspecialchars($category['category_image']); ?>"
                                                                alt="Category Image"
                                                                style="width:80px;height:60px;object-fit:cover;border-radius:8px;">

                                                        <?php } else { ?>

                                                            <!-- eza ma fi sora -->

                                                            <span>
                                                                No Image
                                                            </span>

                                                        <?php } ?>

                                                    </td>


                                                    <!-- Category Name -->

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $category['categories_name']
                                                        );

                                                        ?>

                                                    </td>


                                                    <!-- Description -->

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $category['description']
                                                        );

                                                        ?>

                                                    </td>


                                                    <!-- Actions -->

                                                    <td>


                                                        <!-- Edit Button -->

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-success edit-category"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editCategoryModal"

                                                            data-id="<?php echo $category['categories_id']; ?>"

                                                            data-name="<?php echo htmlspecialchars(
                                                                $category['categories_name'],
                                                                ENT_QUOTES
                                                            ); ?>"

                                                            data-description="<?php echo htmlspecialchars(
                                                                $category['description'],
                                                                ENT_QUOTES
                                                            ); ?>"

                                                            data-image="<?php echo htmlspecialchars(
                                                                $category['category_image'] ?? '',
                                                                ENT_QUOTES
                                                            ); ?>">

                                                            Edit

                                                        </button>


                                                        <!-- Delete Button -->

                                                        <a
                                                            href="delete_categories.php?cat_id=<?php echo $category['categories_id']; ?>"
                                                            class="btn btn-sm btn-outline-danger">

                                                            Delete

                                                        </a>


                                                    </td>

                                                </tr>

                                            <?php } ?>

                                        </tbody>


                                    </table>

                                </div>

                            </div>

                            <!-- End Categories Table -->


                        </div>

                    </div>

                </div>

            </div>

            <!-- End Categories Content -->


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


    <!-- Edit Category JavaScript -->

    <script>

        document.querySelectorAll('.edit-category').forEach(function(button) {

            button.addEventListener('click', function() {

                // hon mnجيب data taba3 l category

                const id = this.getAttribute('data-id');

                const name = this.getAttribute('data-name');

                const description = this.getAttribute('data-description');

                const image = this.getAttribute('data-image');


                // hon mnحط l data bl Edit Modal

                document.getElementById('edit_cat_id').value = id;

                document.getElementById('edit_cat_name').value = name;

                document.getElementById('edit_des').value = description;


                // hon mnجيب image preview element

                const imagePreview = document.getElementById(
                    'edit_category_image_preview'
                );


                // hon mnجيب hidden input taba3 current image

                const currentImage = document.getElementById(
                    'edit_current_image'
                );


                // hon mnحط essem l sora l2dime bl hidden input

                currentImage.value = image;


                // eza fi sora

                if (image !== '') {

                    // hon mnحط path taba3 l sora

                    imagePreview.src = "../uploads/categories/" + image;

                    // hon mnظهر l sora

                    imagePreview.style.display = "block";

                } else {

                    // eza ma fi sora, mnخبي l preview

                    imagePreview.src = "";

                    imagePreview.style.display = "none";

                }

            });

        });

    </script>


</body>

</html>