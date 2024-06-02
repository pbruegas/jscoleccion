<?php
// Include database connection
include('conn.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize data from the POST request
    $productId = mysqli_real_escape_string($con, $_POST['productId']);
    $productName = mysqli_real_escape_string($con, $_POST['productName']);
    $productPrice = mysqli_real_escape_string($con, $_POST['productPrice']);
    $productImage = mysqli_real_escape_string($con, $_POST['productImage']);
    $availableItems = mysqli_real_escape_string($con, $_POST['availableItems']);

    // Retrieve additional product data from the 'products' table based on $productId
    $query = "SELECT * FROM products WHERE prod_id = $productId";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $productData = mysqli_fetch_assoc($result);

        // Extract necessary data from the 'products' table
        $cartId = $productData['prod_id'];
        $cartImg = $productData['img_fileName'];
        $cartProd = $productData['prod_category'];
        $cartName = $productData['prod_name'];
        $cartPrice = $productData['prod_price'];
        $quantity = $productData['avail_items'];


        // Add the product to the 'cart' table in the database
        $insertQuery = "INSERT INTO cart (cart_id, cart_img, cart_prod, cart_name, cart_price, quantity) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insertQuery);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'isssss', $cartId, $cartImg, $cartProd, $cartName, $cartPrice, $quantity);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Product added to cart successfully
            $response = array('status' => 'success', 'message' => 'Product added to cart.');
        } else {
            // Error adding product to cart
            $errorMessage = mysqli_error($con);
            $response = array('status' => 'error', 'message' => 'Failed to add product to cart: ' . $errorMessage);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Product not found in the 'products' table
        $response = array('status' => 'error', 'message' => 'Product not found.');
    }

    // Close the database connection
    mysqli_close($con);

    // Output the response as JSON
    echo json_encode($response);
} else {
    // Invalid request method
    $response = array('status' => 'error', 'message' => 'Invalid request method.');

    // Output the response as JSON
    echo json_encode($response);
}
?>
