<?php
// Include database connection
include('conn.php');

// Query to get the count of items in the cart
$query = "SELECT COUNT(*) AS itemCount FROM cart";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $itemCount = $row['itemCount'];
    echo $itemCount;
} else {
    echo '0';
}

// Close database connection
mysqli_close($con);
?>

