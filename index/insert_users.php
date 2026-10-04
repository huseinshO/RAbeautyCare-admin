<?php //bt5dn mn  page users.php heye feha lform
require('conn.php');
if($_POST){
    $user = $_POST['username'];//hsb lform 
    $pass = $_POST['password'];
    $hashed_pass=password_hash($pass, PASSWORD_DEFAULT);//krml ykon hashed mesh ynktb mtl ma hwe
    // var_dump($hashed_pass);exit;
    $role = $_POST['role'];

    $check_sql="select * from users where usersname=?"; //hsb database
    $check_stmt=$conn->prepare($check_sql);
    $check_stmt->bind_param("s", $user);
    $check_stmt->execute();
    $check_result=$check_stmt->get_result();
    if($check_result->num_rows > 0){//krml ma ykon kaza user nfs name
        echo "User already exists.";
        exit;

    } else{
        
    $sql = "INSERT INTO users (usersname, password, role) VALUES (?, ?, ?)";//hsb database
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("sss", $user, $hashed_pass, $role);
    if($stmt->execute() === TRUE){
        echo "User added successfully.";
        echo "<script>window.location.href='users.php';</script>";//btrj3ne 3a users page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


}
?>



