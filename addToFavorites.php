<?php
session_start();
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = mysqli_real_escape_string($con, $_POST['productId']);
    $productName = mysqli_real_escape_string($con, $_POST['productName']);
    $productCategory = mysqli_real_escape_string($con, $_POST['productCategory']);
    $productImage = mysqli_real_escape_string($con, $_POST['productImage']);
    $productPrice = mysqli_real_escape_string($con, $_POST['productPrice']);

    $query = "INSERT INTO favorites (fav_id, fav_category, fav_imgfileName, fav_name, fav_price) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, 'issss', $productId, $productCategory, $productImage, $productName, $productPrice);

    if (mysqli_stmt_execute($stmt)) {
        $response = array('status' => 'success', 'message' => 'Product added to favorites.');
    } else {
        $errorMessage = mysqli_error($con);
        $response = array('status' => 'error', 'message' => 'Failed to add product to favorites: ' . $errorMessage);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    echo json_encode($response);
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request method.');
    echo json_encode($response);
}
?>
