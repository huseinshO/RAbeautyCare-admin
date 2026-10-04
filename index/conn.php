
<?php
//create connection:hyda lms2ol 3an lconnection maa database
$servername = "localhost";//identify my server le hwe local host
$username = "root";
$password = "";
$dbname = "ra_beautycare";//db le elna

//create connection:
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection:
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}





?>

