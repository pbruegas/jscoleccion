<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "signup"; 

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

function filteration($data){
    foreach($data as $key => $value){
    $data[$key] = trim($value);
    $data[$key] = stripslashes($value);
    $data[$key] = htmlspecialchars($value);
    $data[$key] = strip_tags($value);

    }
    return $data;
}

function adminLogin()
{
    session_start();
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] ==true)){
     echo"<script>window.location.href='index.php'</script>";
    }
    session_regenerate_id(true);
}
?>
