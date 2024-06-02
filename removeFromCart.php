<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Perform SQL query to remove item from cart
    $query = "DELETE FROM cart WHERE cart_id = '$productId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove item from cart.']);
    }
}
?>
