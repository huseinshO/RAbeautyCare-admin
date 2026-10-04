<?php

if ($_POST) {

    include("conn.php");

    // var_dump($_POST);

    $cat_name = trim($_POST['cat_name']); 
    // hasab sho msameha bl name tb3 l form , trim krml tshel spaces

    $description = trim($_POST['des']);
   

    $user_id = $_POST['user_id'];
    // hon bnakhod l user_id mn l form


    // Image
    // hon bnakhod essem l sora mn l form

    $image_name = $_FILES['category_image']['name'];

    // hon bnakhod l temporary path taba3 l sora

    $image_tmp = $_FILES['category_image']['tmp_name'];


    if ($cat_name === '' || $description === '') { 
        // validation eno eza empty

        die("Category name and description are required."); 
        // bt3tene hyde masseg
    }


    // Check if category already exists
    // hon mncheck eza l category mawjoude abel
    $sql = "SELECT categories_name FROM categories WHERE categories_name = ?";

    // hyde lprepare krml security, prevent sql injection
    $stmt = $conn->prepare($sql);

    // s y3ne string, hon s krml cat_name hwe string
    $stmt->bind_param("s", $cat_name);

    // execute lal query
    $stmt->execute();

    // hon mnjib lresult taba3 lquery
    $result = $stmt->get_result();


    if ($result->num_rows > 0) { 
        // num rows bt3d rows, krml eza kanet akbr mn 0 y3ne category mwjode
        echo "Category already exists.";

    } else {


    
      //Upload Category Image

        // hon mncheck eza luser 3amel upload lal sora

        if (!isset($_FILES['category_image']) || $_FILES['category_image']['error'] !== 0) {

            die("Category image is required.");
            // eza ma fi sora, bt3tene error message

        }


        // hon mn7ot l extensions lmasmou7a

        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];


        // hon mnakhod extension taba3 l sora

        $image_extension = strtolower(
            pathinfo($image_name, PATHINFO_EXTENSION)
        );


        // hon mncheck eza extension taba3 l sora masmou7a

        if (!in_array($image_extension, $allowed_types)) {

            die("Only JPG, JPEG, PNG and WEBP images are allowed.");
            // eza extension mesh masmou7a, btwa2ef l code w bt3ti message

        }


        // Create unique image name
        // hon mn3amel essem unique lal sora krml ma ysir conflict ma3 sora tene

        $new_image_name = uniqid('category_', true) . '.' . $image_extension;


        // Upload folder
        // hon mn7added l folder wen badna nkhazen sowar l categories

        $upload_folder = "../uploads/categories/";


        // Create folder if it doesn't exist
        // eza l folder mawjoud ma by3mel shi
        // eza mesh mawjoud by3mlo automatically

        if (!is_dir($upload_folder)) {

            mkdir($upload_folder, 0777, true);

        }


        // hon mn3amel l full path taba3 l sora

        $image_path = $upload_folder . $new_image_name;


        // hon mn2oul l sora mn l temporary folder 3a uploads/categories

        if (!move_uploaded_file($image_tmp, $image_path)) {

            die("Error uploading category image.");
            // eza ma nzalet l sora 3a l folder, bt3ti error

        }


        // =========================
        // Insert Category
        // =========================

        // hon l INSERT query
        // 3anna 4 values:
        // category name
        // description
        // user id
        // image name

        $sql = "INSERT INTO categories
                (categories_name, description, users_id, category_image)
                VALUES (?, ?, ?, ?)";


        // hyda prepare lal execute ma3 security
        // prevent SQL Injection

        $insertStmt = $conn->prepare($sql);


        // hon mn3abe l ? values
        // s = string
        // s = string
        // i = integer
        // s = string

        $insertStmt->bind_param(
            "ssis",
            $cat_name,
            $description,
            $user_id,
            $new_image_name
        );


        // hon mnexecute l INSERT query

        if ($insertStmt->execute()) {

            // eza l INSERT نجح
            // bnrou7 3a categories.php

            header("Location: categories.php");

            // exit krml nwa2ef l code ba3d l redirect

            exit;

        } else {

            // eza fi error bel INSERT

            echo "Error adding category.";

        }


        // close lal statement

        $insertStmt->close();

    }


    // close lal statement taba3 check category

    $stmt->close();


    // close lal database connection

    $conn->close();

}

?>