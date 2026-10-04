<?php

include("../index/conn.php");

/* Categories */
$sql_categories = "
    SELECT categories_id, categories_name, description, category_image
    FROM categories
    ORDER BY categories_id ASC
";
$result_categories = $conn->query($sql_categories);
if (!$result_categories) {
    die("Categories query error: " . $conn->error);
}
$categories = $result_categories->fetch_all(MYSQLI_ASSOC);

/* Services */
$sql_services = "
  SELECT service_id, service_name, description, icon
FROM services
WHERE is_active = 1
ORDER BY service_id ASC
";
$result_services = $conn->query($sql_services);
if (!$result_services) {
    die("Services query error: " . $conn->error);
}
$services = $result_services->fetch_all(MYSQLI_ASSOC);

/* About Us */
$sql_about = "
  SELECT
    about_id,
    title,
    text_one,
    text_two,
    image_one
FROM about_us
ORDER BY about_id ASC
LIMIT 1
";
$result_about = $conn->query($sql_about);
if (!$result_about) {
    die("About query error: " . $conn->error);
}
$about = $result_about->fetch_assoc();

/* Products */
$sql_products = "
    SELECT
        products.products_id,
        products.products_name,
        products.categories_id,
        products.price,
        products.products_image,
        products.description,
        categories.categories_name
    FROM products
    LEFT JOIN categories
        ON categories.categories_id = products.categories_id
    ORDER BY products.products_id DESC
";
$result_products = $conn->query($sql_products);
if (!$result_products) {
    die("Products query error: " . $conn->error);
}
$products = $result_products->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>RA BeautyCare - Skincare & Beauty</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="skincare, beauty care, cleanser, serum, moisturizer, RA BeautyCare" name="keywords">
    <meta content="RA BeautyCare - skincare and beauty care products." name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=PT+Serif:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    
  <!-- Navbar Start -->
<div class="container-fluid bg-light fixed-top" style="z-index: 9999;">
    <div class="container px-0">
        <nav class="navbar navbar-light navbar-expand-xl">

            <a href="index.php" class="navbar-brand d-flex align-items-center">
                <img src="img/rowaida-logo.png"
                     alt="Rowaida Assi - Skin Care & Cosmetics"
                     style="height:78px; width:auto;">
            </a>

            <button class="navbar-toggler py-2 px-3"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>

            <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">

                <ul class="navbar-nav mx-auto border-top">

                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">Home</a>
                    </li>

                    <li class="nav-item">
                        <a href="#categories" class="nav-link">Categories</a>
                    </li>

                    <li class="nav-item">
                        <a href="#services" class="nav-link">Services</a>
                    </li>

                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>

                    <li class="nav-item">
                        <a href="#products" class="nav-link">Products</a>
                    </li>

                    <li class="nav-item">
                        <a href="#appointment" class="nav-link">Appointment</a>
                    </li>

                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>

                </ul>

                <div class="d-flex align-items-center flex-nowrap pt-xl-0">

                    <a href="#appointment"
                       class="nav-item nav-link btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-4 ms-4">
                        Book Appointment
                    </a>

                </div>

            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
    


   <!-- Carousel Start -->
<div class="container-fluid carousel-header px-0">
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
            <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">

            <div class="carousel-item active">
                <img src="img/cc1.png" class="img-fluid" alt="Image">
                <!-- caption -->
                <!-- <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-primary text-uppercase mb-3">RA BeautyCare</h4>
                        <h1 class="display-1 text-capitalize text-dark mb-3">Healthy Skin Starts Here</h1>
                        <p class="mx-md-5 fs-4 px-4 mb-5 text-dark">
                            Discover skincare essentials made to cleanse, hydrate, nourish and protect your skin.
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-light btn-light-outline-0 rounded-pill py-3 px-5 me-4"
                               href="#products">Discover Products</a>
                            <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5"
                               href="#categories">Shop Now</a>
                        </div>
                    </div>

                </div> -->
            </div>

            <div class="carousel-item">
                <img src="img/carousal-2.jpg" class="img-fluid" alt="Image">

                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-primary text-uppercase mb-3" style="letter-spacing: 3px;">RA BeautyCare</h4>
                        <h1 class="display-1 text-capitalize text-dark mb-3">Glow With Confidence</h1>
                        <p class="mx-md-5 fs-4 px-5 mb-5 text-dark">
                            Discover skincare essentials made to cleanse, hydrate, nourish and protect your skin.
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <!-- <a class="btn btn-light btn-light-outline-0 rounded-pill py-3 px-5 me-4"
                               href="#products">Discover Products</a> -->
                            <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5"
                               href="#categories">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/carousel-3.png" class="img-fluid" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-primary text-uppercase mb-3" style="letter-spacing: 3px;">RA BeautyCare</h4>
                        <h1 class="display-1 text-capitalize text-dark">Your Daily Skincare Ritual</h1>
                        <p class="mx-md-5 fs-4 px-5 mb-5 text-dark">
                            Discover skincare essentials made to cleanse, hydrate, nourish and protect your skin.
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-light btn-light-outline-0 rounded-pill py-3 px-5 me-4"
                               href="#products">Discover Products</a>
                            <!-- <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5"
                               href="#categories">Shop Now</a> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->

    <!--  Categories Start -->
<section id="categories" class="categories-section">
    <div class="container">

        <div class="text-center mb-5">
            <p class="section-label">OUR CATEGORIES</p>
            <h2>Shop By Category</h2>
            <p class="text-muted">Discover our skincare, hair care and body care collection.</p>
        </div>

        <div class="row g-4">

            <?php if (!empty($categories)): ?>

                <?php foreach ($categories as $category): ?>

                    <div class="col-lg-4 col-md-6">
                        <div class="category-card">

                            <!-- hon mn3ared sora taba3 l category mn uploads/categories -->
                            <img
                                src="<?php echo !empty($category['category_image'])
                                    ? '../uploads/categories/' . htmlspecialchars($category['category_image'])
                                    : 'img/product-base.jpg'; ?>"
                                alt="<?php echo htmlspecialchars($category['categories_name']); ?>"
                                class="category-image">

                            <div class="category-content">

                                <h3><?php echo htmlspecialchars($category['categories_name']); ?></h3>

                                <p><?php echo htmlspecialchars($category['description']); ?></p>

                                <a
                                    href="#products"
                                    class="category-btn category-filter"
                                    data-filter="<?php echo (int)$category['categories_id']; ?>">
                                    View Products
                                </a>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12 text-center">
                    <h3>Coming Soon</h3>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>
<!-- Categories End -->

<!-- Services Start -->
<div class="container-fluid py-5" id="services">
    <div class="container">

        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <p class="d-inline-block bg-primary text-white py-1 px-4">Our Services</p>
            <h1 class="display-5">Beauty & Care Services</h1>
            <p class="text-muted">
                Professional beauty and care treatments designed to help you look and feel your best.
            </p>
        </div>

        <div class="row g-4">

            <?php if (!empty($services)): ?>

                <?php foreach ($services as $service): ?>

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item bg-light text-center p-4 h-100">

                            <div class="service-icon mb-4">
                                <i class="<?php echo htmlspecialchars($service['icon'] ?: 'fa fa-star'); ?> fa-3x text-primary"></i>
                            </div>

                            <h4 class="mb-3">
                                <?php echo htmlspecialchars($service['service_name']); ?>
                            </h4>

                            <p class="mb-0">
                                <?php echo htmlspecialchars($service['description']); ?>
                            </p>

                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12 text-center">
                    <h3>Coming Soon</h3>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<!-- Services End -->

    <!--  About Start -->

<div class="container-fluid about py-5" id="about">
    <div class="container py-5">

        <?php if (!empty($about)): ?>

            <div class="row g-5 align-items-center">

                <!-- About Us Image Start -->
                <div class="col-lg-5">

                    <!-- Image One -->
                    <div class="mb-4">

                        <?php if (!empty($about['image_one'])): ?>

                            <!-- hon mnجيب image one mn uploads/about -->
                            <img
                                src="../uploads/about/<?php echo htmlspecialchars($about['image_one']); ?>"
                                class="img-fluid rounded w-100"
                                alt="RA BeautyCare"
                                style="height: 420px; object-fit: cover;">

                        <?php else: ?>

                            <!-- eza ma fi image one, mnعرض default image -->
                            <img
                                src="img/product-base.jpg"
                                class="img-fluid rounded w-100"
                                alt="RA BeautyCare"
                                style="height: 420px; object-fit: cover;">

                        <?php endif; ?>

                    </div>


                </div>
                <!-- About Us Image End -->

                <div class="col-lg-7">

                    <p class="fs-4 text-uppercase text-primary">About Us</p>

                    <h1 class="display-4 mb-4">
                        <?php echo htmlspecialchars($about['title']); ?>
                    </h1>

                    <p class="mb-4 about-text-ar" dir="rtl">
                        <?php echo htmlspecialchars($about['text_one']); ?>
                    </p>

                    <p class="mb-4 about-text-ar" dir="rtl">
                        <?php echo htmlspecialchars($about['text_two']); ?>
                    </p>

                    <!-- Static About Us Button -->
                    <!-- hon l button static, ya3ne ma ba2a ya5od button text/link mn database -->
                    <a
                        href="#appointment"
                        class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5">
                        Appointment Now
                    </a>

                </div>
            </div>

        <?php else: ?>

            <div class="text-center">
                <h3>About Us Coming Soon</h3>
            </div>

        <?php endif; ?>

    </div>
</div>
<!-- About End -->


<!-- Products Start -->
<div class="container-fluid pricing py-5" id="products">

    <div class="container py-5">


        <!-- =====================================================
             Products Section Title
        ====================================================== -->

        <div
            class="text-center mx-auto mb-5"
            style="max-width: 800px;">

            <p class="fs-4 text-uppercase text-primary">

                Our Products

            </p>

            <h1 class="display-4 mb-4">

                RA BeautyCare Collection

            </h1>

            <p class="mb-0">

                Discover our beauty and skincare collection.

            </p>

        </div>



        <!-- =====================================================
             Category Buttons
        ====================================================== -->

        <ul
            class="nav nav-pills justify-content-center mb-5"
            id="productCategoryTabs"
            role="tablist">


            <!-- ALL BUTTON -->

            <li
                class="nav-item"
                role="presentation">

                <button
                    class="nav-link active rounded-pill py-2 px-4 mx-1 mb-2"
                    id="all-products-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#all-products"
                    type="button"
                    role="tab"
                    aria-controls="all-products"
                    aria-selected="true">

                    All

                </button>

            </li>



            <!-- CATEGORY BUTTONS -->

            <?php foreach ($categories as $category): ?>

                <li
                    class="nav-item"
                    role="presentation">

                    <button
                        class="nav-link rounded-pill py-2 px-4 mx-1 mb-2"
                        id="category-tab-<?php echo (int)$category['categories_id']; ?>"
                        data-bs-toggle="pill"
                        data-bs-target="#category-products-<?php echo (int)$category['categories_id']; ?>"
                        type="button"
                        role="tab"
                        aria-controls="category-products-<?php echo (int)$category['categories_id']; ?>"
                        aria-selected="false">

                        <?php
                        echo htmlspecialchars(
                            $category['categories_name']
                        );
                        ?>

                    </button>

                </li>

            <?php endforeach; ?>


        </ul>



        <!-- =====================================================
             Products Tab Content
        ====================================================== -->

        <div
            class="tab-content"
            id="productCategoryTabContent">


            <!-- =================================================
                 ALL PRODUCTS
            ================================================== -->

            <div
                class="tab-pane fade show active"
                id="all-products"
                role="tabpanel"
                aria-labelledby="all-products-tab">


                <div class="row g-4">


                    <?php if (!empty($products)): ?>


                        <?php foreach ($products as $product): ?>


                            <div class="col-lg-4 col-md-6">


                                <div class="pricing-item h-100">

                                    <div
                                        class="pricing-content rounded h-100">


                                        <!-- Product Image -->

                                        <img
                                            src="<?php
                                            echo !empty(
                                                $product['products_image']
                                            )
                                                ? '../uploads/products/' .
                                                  htmlspecialchars(
                                                      $product['products_image']
                                                  )
                                                : 'img/product-base.jpg';
                                            ?>"
                                            class="img-fluid w-100 rounded-top product-image"
                                            alt="<?php echo htmlspecialchars($product['products_name']); ?>"
                                            style="
                                                height:300px;
                                                object-fit:cover;
                                            ">


                                        <!-- Product Name & Price -->

                                        <div
                                            class="bg-light border-3 border-bottom border-primary p-4 text-center">


                                            <h3 class="text-primary mb-2">

                                                <?php
                                                echo htmlspecialchars(
                                                    $product['products_name']
                                                );
                                                ?>

                                            </h3>


                                            <h4 class="mb-0 text-dark">

                                                <?php
                                                echo htmlspecialchars(
                                                    $product['price']
                                                );
                                                ?>$

                                            </h4>


                                        </div>


                                        <!-- Product Description -->

                                        <div class="p-4 text-center">


                                            <p>

                                                <?php

                                                if (
                                                    !empty(
                                                        $product['description']
                                                    )
                                                ) {

                                                    echo htmlspecialchars(
                                                        $product['description']
                                                    );

                                                } else {

                                                    echo htmlspecialchars(
                                                        $product['categories_name']
                                                    );

                                                }

                                                ?>

                                            </p>


                                            <a
                                                href="#contact"
                                                class="btn btn-primary rounded-pill my-2 px-4">

                                                Contact Us

                                            </a>


                                        </div>


                                    </div>

                                </div>


                            </div>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <div class="col-12 text-center">

                            <h3>

                                Products Coming Soon

                            </h3>

                        </div>


                    <?php endif; ?>


                </div>

            </div>



            <!-- =================================================
                 PRODUCTS BY CATEGORY
            ================================================== -->

            <?php foreach ($categories as $category): ?>


                <div
                    class="tab-pane fade"
                    id="category-products-<?php echo (int)$category['categories_id']; ?>"
                    role="tabpanel"
                    aria-labelledby="category-tab-<?php echo (int)$category['categories_id']; ?>">


                    <div class="row g-4">


                        <?php

                        /*
                         * This variable checks whether
                         * the current category has products.
                         */

                        $category_has_products = false;


                        /*
                         * Loop through all products.
                         */

                        foreach ($products as $product):


                            /*
                             * Display only products that belong
                             * to the current category.
                             */

                            if (
                                (int)$product['categories_id']
                                ===
                                (int)$category['categories_id']
                            ):


                                $category_has_products = true;

                        ?>


                                <!-- Product -->

                                <div
                                    class="col-lg-4 col-md-6">


                                    <div
                                        class="pricing-item h-100">


                                        <div
                                            class="pricing-content rounded h-100">


                                            <!-- Product Image -->

                                            <img
                                                src="<?php
                                                echo !empty(
                                                    $product['products_image']
                                                )
                                                    ? '../uploads/products/' .
                                                      htmlspecialchars(
                                                          $product['products_image']
                                                      )
                                                    : 'img/product-base.jpg';
                                                ?>"
                                                class="img-fluid w-100 rounded-top product-image"
                                                alt="<?php echo htmlspecialchars($product['products_name']); ?>"
                                                style="
                                                    height:300px;
                                                    object-fit:cover;
                                                ">


                                            <!-- Product Name & Price -->

                                            <div
                                                class="bg-light border-3 border-bottom border-primary p-4 text-center">


                                                <h3
                                                    class="text-primary mb-2">

                                                    <?php
                                                    echo htmlspecialchars(
                                                        $product['products_name']
                                                    );
                                                    ?>

                                                </h3>


                                                <h4
                                                    class="mb-0 text-dark">

                                                    <?php
                                                    echo htmlspecialchars(
                                                        $product['price']
                                                    );
                                                    ?>$

                                                </h4>


                                            </div>


                                            <!-- Product Description -->

                                            <div
                                                class="p-4 text-center">


                                                <p>

                                                    <?php

                                                    if (
                                                        !empty(
                                                            $product['description']
                                                        )
                                                    ) {

                                                        echo htmlspecialchars(
                                                            $product['description']
                                                        );

                                                    } else {

                                                        echo htmlspecialchars(
                                                            $category['categories_name']
                                                        );

                                                    }

                                                    ?>

                                                </p>


                                                <a
                                                    href="#contact"
                                                    class="btn btn-primary rounded-pill my-2 px-4">

                                                    Contact Us

                                                </a>


                                            </div>


                                        </div>

                                    </div>


                                </div>


                        <?php

                            endif;

                        endforeach;

                        ?>


                        <!-- No Products -->

                        <?php if (!$category_has_products): ?>


                            <div
                                class="col-12 text-center">

                                <div
                                    class="bg-light rounded p-5">

                                    <h4>

                                        No products available
                                        in this category.

                                    </h4>

                                </div>

                            </div>


                        <?php endif; ?>


                    </div>


                </div>


            <?php endforeach; ?>


        </div>

    </div>

</div>
<!-- Products End -->

<!-- Appointment Start -->
<div class="container-fluid appointment-section py-5" id="appointment">

    <div class="container py-5">

        <div class="text-center mx-auto mb-5" style="max-width: 700px;">

            <p class="fs-4 text-uppercase text-primary">
                Book Your Session
            </p>

            <h1 class="display-4 mb-4">
                Make An Appointment
            </h1>

            <p class="mb-0">
                Book your beauty care session with RA BeautyCare.
            </p>

        </div>


        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="appointment-form bg-light p-5 rounded">

                    <form action="../index/insert_appointment.php" method="POST">

                        <div class="row g-4">


                            <!-- Full Name -->

                            <div class="col-md-6">

                                <input
                                    type="text"
                                    name="customer_name"
                                    class="form-control border-0 py-3 px-4"
                                    placeholder="Full Name"
                                    required>

                            </div>


                            <!-- Phone -->

                            <div class="col-md-6">

                                <input
                                    type="number"
                                    name="phone"
                                    class="form-control border-0 py-3 px-4"
                                    placeholder="Phone Number"
                                    required>

                            </div>


                            <!-- Service -->

                            <div class="col-md-6">

                                <select
                                    name="service"
                                    class="form-select border-0 py-3 px-4"
                                    required>
                                    <option value="">
                                        Select Session
                                    </option>

                                    <?php foreach ($services as $service): ?>
                                        <option value="<?php echo htmlspecialchars($service['service_name']); ?>">
                                            <?php echo htmlspecialchars($service['service_name']); ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- Date -->

                            <div class="col-md-6">

                                <input
                                    type="date"
                                    name="appointment_date"
                                    class="form-control border-0 py-3 px-4"
                                    required>

                            </div>


                            <!-- Time -->

                            <div class="col-md-6">

                                <input
                                    type="time"
                                    name="appointment_time"
                                    class="form-control border-0 py-3 px-4"
                                    required>

                            </div>


                            <!-- Notes -->

                            <div class="col-12">

                                <textarea
                                    name="notes"
                                    class="form-control border-0 py-3 px-4"
                                    rows="5"
                                    placeholder="Additional Notes"></textarea>

                            </div>


                            <!-- Submit -->

                            <div class="col-12 text-center">

                                <button
                                    type="submit"
                                    class="btn btn-primary rounded-pill py-3 px-5">

                                    Book Appointment

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- Appointment End -->

    <!-- Testimonial Start -->
<div class="container-fluid testimonial py-5" id="testimonials">
    <div class="container py-5 mt-5">
        <div class="text-center mx-auto" style="max-width: 800px;">
            <p class="fs-4 text-uppercase text-primary">Client Feedback</p>
            <h1 class="display-4 mb-4 text-white">What Our Clients Say</h1>
            <p class="text-white mb-0">
                Client reviews will be displayed here soon.
            </p>
        </div>
    </div>
</div>
<!-- Testimonial End -->





    <!-- Contact Start -->
    <div class="container-fluid py-5" id="contact">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <p class="fs-4 text-uppercase text-primary">Contact Us</p>
                <h1 class="display-4 mb-4">Get In Touch With RA BeautyCare</h1>
                <p class="mb-0">For product information, beauty sessions and appointments, contact us through our social channels or WhatsApp.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="bg-light rounded p-4 text-center h-100">
                        <i class="fab fa-whatsapp fa-3x text-primary mb-3"></i>
                        <h4>WhatsApp</h4>
                        <a href="https://wa.me/96171503106" class="text-muted">71 503 106</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light rounded p-4 text-center h-100">
                        <i class="fab fa-instagram fa-3x text-primary mb-3"></i>
                        <h4>Instagram</h4>
                        <a href="https://www.instagram.com/ra.skincare.lb" class="text-muted">@ra.skincare.lb</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light rounded p-4 text-center h-100">
                        <i class="fab fa-tiktok fa-3x text-primary mb-3"></i>
                        <h4>TikTok</h4>
                        <a href="https://www.tiktok.com/@ra_beautyskincare" class="text-muted">@ra_beautyskincare</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Footer Start -->
    <div class="container-fluid footer py-5 mt-5">
        <div class="container py-5">
            <div class="row g-5">

                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Our Services</h4>
                        <a href="#services"><i class="fas fa-angle-right me-2"></i> HIFU</a>
                        <a href="#services"><i class="fas fa-angle-right me-2"></i> EMFACE</a>
                        <a href="#services"><i class="fas fa-angle-right me-2"></i> Skin Cleansing</a>
                        <a href="#services"><i class="fas fa-angle-right me-2"></i> Body & Hair Care</a>

                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Schedule</h4>
                        <p class="text-muted mb-0">Tuesday: <span class="text-white"> 09:00 am – 10:00 pm</span></p>
                        <p class="text-muted mb-0">Thursday: <span class="text-white"> 09:00 am – 08:00 pm</span></p>
                        <p class="text-muted mb-0">Saturday: <span class="text-white"> 09:00 am – 05:00 pm</span></p>
                        <h4 class="my-4 text-white">Address</h4>
                        <p class="mb-0"><i class="fas fa-map-marker-alt text-secondary me-2"></i>  Beirut, Airport Road 
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Follow Us</h4>
                        <!-- <a href="https://www.facebook.com/RA.BeautyCare"><i class="fas fa-angle-right me-2"></i> Faceboock</a> -->
                        <a href="https://www.instagram.com/ra.skincare.lb?stkn=MWY5bTE5NHVtN2YwNQ=="><i class="fas fa-angle-right me-2"></i> Instagram</a>
                        <a href="https://www.tiktok.com/@ra_beautyskincare?_r=1&_t=ZS-9ADjcrPB4oz"><i class="fas fa-angle-right me-2"></i> TikTok</a>

                        <h4 class="my-4 text-white">Contact Us</h4>
                        <a href="https://wa.me/96171503106"><i class="fas fa-angle-right me-2"></i> WhatsApp</a>
                        <p class="mb-0"><i class="fas fa-phone text-secondary me-2"></i>71 503 106</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->



    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-4 text-center text-md-start mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>RA
                            BeautyCare</a>, All right reserved.</span>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-center">
                        <!-- <a href="" class="btn btn-light btn-light-outline-0 btn-sm-square rounded-circle me-2"><i
                                class="fab fa-facebook-f"></i></a> -->
                        <a href="https://www.instagram.com/ra.skincare.lb?stkn=MWY5bTE5NHVtN2YwNQ==" class="btn btn-light btn-light-outline-0 btn-sm-square rounded-circle me-2"><i
                                class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@ra_beautyskincare?_r=1&_t=ZS-9ADjcrPB4oz" class="btn btn-light btn-light-outline-0 btn-sm-square rounded-circle me-2"><i
                                class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end text-white">
                    Developed By <a class="border-bottom" href="https://www.instagram.com/husein_sh0_">Hussein shaker</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#top" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top ">
        <i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    
</body>

</html>