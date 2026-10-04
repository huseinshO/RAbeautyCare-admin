   <div class="sidebar pe-4 pb-3 mt-3">
            <nav class="navbar bg-light navbar-light">
              <a href="index.php" class="navbar-brand mx-4 mb-3">
    <h3 class="text-primary">
        <i class="fas fa-tachometer-alt me-2"></i>ADMIN
    </h3></a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../raweb/img/rowaida-logo.png" alt="logo" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">RA</h6>
                        <span>Admin Dashboard</span>
                    </div>
                </div>
             <div class="navbar-nav w-100">

    <!-- Dashboard -->
    <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) =='index.php' ? 'active': ''; ?>">
        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
    </a>

    <!-- Categories -->
    <a href="categories.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>">
        <i class="fa fa-layer-group me-2"></i>Categories
    </a>

    <!-- Services -->
    <a href="services.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
        <i class="fa fa-spa me-2"></i>Services
    </a>

    <!-- About Us -->
    <a href="about_us.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about_us.php' ? 'active' : ''; ?>">
        <i class="fa fa-heart me-2"></i>About Us
    </a>

    <!-- Products -->
    <a href="products.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">
        <i class="fa fa-box-open me-2"></i>Products
    </a>

    <!-- Appointments -->
    <a href="appointments.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
        <i class="fa fa-calendar-check me-2"></i>Appointments
    </a>

    <!-- Users -->
    <a href="users.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
        <i class="fa fa-users me-2"></i>Users
    </a>

    <!-- Pages -->
    <!-- <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="far fa-file-alt me-2"></i>Pages
        </a>

        <div class="dropdown-menu bg-transparent border-0">

            
            <a href="signup.php" class="dropdown-item">
                <i class="fa fa-user-plus me-2"></i>Sign Up
            </a>

        </div>
        
    </div> -->

</div>
            </nav>
        </div>