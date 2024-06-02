<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="cartstyle.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="./style-prefix.css">
        
</head>

<body>
    <header>
        <div class="header-main">
            <div class="container">
                <a href="index.php" class="header-logo">
                    <img src="./logo.png" alt="logo" width="120" height="36">
                </a>

                <div class="header-user-actions">
                    <?php if (isset($_SESSION['email'])): ?>
                        <!-- Display logout button if user is logged in -->
                            <form action="logout.php" method="post">
                            <button type="submit" class="action-btn" name="logout">
                            <ion-icon name="log-out-outline"></ion-icon>
                            </button>
                            </form>
                    <?php else: ?>
                        <!-- Display login button if user is not logged in -->
                            <a href="login.php" class="login-link">
                            <button class="action-btn">
                            <ion-icon name="person-outline"></ion-icon>
                            </button>
                            </a>
                    <?php endif; ?>

                    <button class="action-btn">
                        <a href="cart.php" class="btn-action addToBagBtn">
                        <ion-icon name="bag-handle-outline"></ion-icon>
                        <span id="bagCount" class="count">0</span>
                         </a>
                    </button>
                </div>
            </div>
        </div>

        <nav class="desktop-navigation-menu">
            <div class="container">
                <ul class="desktop-menu-category-list">
                    <li class="menu-category">
                        <a href="index.php" class="menu-title">Home</a>
                    </li>
                    <li class="menu-category">
                        <a href="products.php" class="menu-title">Products</a>
                    </li>
                    <li class="menu-category">
                        <a href="contact.php" class="menu-title">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
</header>

    <div class="container-fluid mt-5">
    <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                           <b> My Cart Detail </b>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-lg">
                                <table class="table v-set">
                                    <thead>
                                        <tr>
                                            <th scope="col">    </th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    include('conn.php');

                                    // Execute query
                                    $query = "SELECT * FROM cart";
                                    $result = mysqli_query($con, $query);

                                    // Check for query execution success
                                    if (!$result) {
                                        die("Query failed: " . mysqli_error($con));
                                    }

                                    if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td><input type="checkbox" class="cart-checkbox" data-product-id="' . $row['cart_id'] . '"></td>'; // Checkbox column
                                        echo '<td><img src="./assets/images/products/' . htmlspecialchars($row['cart_img']) . '" class="box-image-set-2" width="100" height="80"></td>';
                                        echo '<td>' . $row['cart_name'] . '</td>';
                                    // Replace $ with ₱ for cart_price
                                    $price_in_pesos = '₱' . number_format($row['cart_price'], 2); // Format price with 2 decimal places
                                    echo '<td>' . $price_in_pesos . '</td>';
                                    
                                    // Default quantity to 1 if not set
                                                $quantity = isset($row['quantity']) ? $row['quantity'] : 2;

                                    echo '<td>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control quantity-input" value="' . $row['quantity'] . '" min="1" data-product-id="' . $row['cart_id'] . '" oninput="updateSubtotal(this)">
                                                        </div>
                                                      </td>';
                                                echo '<td class="subtotal-cell" data-product-id="' . $row['cart_id'] . '">₱' . number_format($row['cart_price'] * $row['quantity'], 2) . '</td>';
                                   
                                            // Action column with remove button
                                                echo '<td data-product-id="' . $row['cart_id'] . '"><button class="btn btn-danger remove-item-btn">Remove</button></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="6">Cart is Empty</td></tr>';
                                        }
                                    ?>

                                    </tbody>
                                    <tfoot>
        <tr>
            <td colspan="5" align="right"><strong>Total:</strong></td>
            <td id="totalAmount" colspan="2"><strong>₱0.00</strong></td>
        </tr>

        <tr>
        <tr>
    <form action="checkout.php" method="post">
        <td colspan="7" align="right">
            <button type="submit" class="btn btn-primary checkout-btn">Checkout</button>
        </td>
    </form>
</tr>

    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="./script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
$(document).ready(function() {
    // Handle quantity change button click
    $('.change-quantity').click(function() {
        var productId = $(this).data('product-id');
        var inputField = $(this).closest('td').find('.quantity-input');
        var currentQuantity = parseInt(inputField.val());
        
        if ($(this).text() === '+') {
            // Increase quantity
            inputField.val(currentQuantity + 1);
        } else if ($(this).text() === '-' && currentQuantity > 1) {
            // Decrease quantity only if greater than 1
            inputField.val(currentQuantity - 1);
        }
    });
});


        $(document).ready(function() {
            // Handle quantity update button click
            $('.update-quantity-btn').click(function() {
                var productId = $(this).data('product-id');
                var newQuantity = $('#quantity_' + productId).val();

                $.ajax({
                    type: 'POST',
                    url: 'updateCartItemQuantity.php',
                    data: {
                        productId: productId,
                        newQuantity: newQuantity
                    },
                    success: function(response) {
                        // Parse the JSON response
                        var jsonResponse = JSON.parse(response);

                        // Check the status of the response
                        if (jsonResponse.status === 'success') {
                            alert('Quantity updated successfully.');
                            // Optionally, update the cart item count dynamically
                            updateCartItemCount();
                        } else {
                            alert('Failed to update quantity: ' + jsonResponse.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating quantity:', error);
                        alert('An error occurred while updating the quantity. Please try again.');
                    }
                });
            });
        });
    </script>

    <script>
    // JavaScript function to update subtotal based on quantity input
function updateSubtotal(input) {
    var quantity = parseInt(input.value);
    var productId = input.dataset.productId;

    // Fetch the price per unit (assuming it's stored in a data attribute)
    var pricePerUnitCell = input.closest('tr').querySelector('td:nth-child(4)');
    var pricePerUnitText = pricePerUnitCell.innerText.trim(); // Get the price text
    var pricePerUnit = parseFloat(pricePerUnitText.replace(/[^\d.]/g, '')); // Extract the numeric value

    // Calculate the subtotal
    var subtotal = pricePerUnit * quantity;

    // Format the subtotal with currency symbol (₱) and thousand separators
    var formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    });
    var formattedSubtotal = formatter.format(subtotal);

    // Update the subtotal cell content
    var subtotalCell = input.closest('tr').querySelector('td.subtotal-cell');
    subtotalCell.textContent = formattedSubtotal;

    // Save the updated quantity to localStorage
    localStorage.setItem('quantity_' + productId, quantity);
}

// Restore the quantity from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
    var quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(function(input) {
        var productId = input.dataset.productId;
        var storedQuantity = localStorage.getItem('quantity_' + productId);

        if (storedQuantity !== null) {
            input.value = storedQuantity; // Set the stored quantity

            // Trigger updateSubtotal to recalculate subtotal on page load
            updateSubtotal(input);
        } else {
            // Set default quantity to 1 if no quantity is stored
            input.value = 1;

            // Trigger updateSubtotal to calculate subtotal for default quantity
            updateSubtotal(input);
        }
    });
});

</script>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    // Function to update cart item count dynamically
    function updateCartItemCount() {
        $.ajax({
            type: 'GET',
            url: 'getCartItemCount.php', // URL to fetch cart item count
            success: function(count) {
                // Update the #bagCount element with the retrieved item count
                $('#bagCount').text(count);
                // Store the count in localStorage to persist across pages
                localStorage.setItem('cartItemCount', count);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching cart item count:', error);
            }
        });
    }

    // Call updateCartItemCount function on page load
    $(document).ready(function() {
        // Retrieve and display the cart item count from localStorage on page load
        var storedCartItemCount = localStorage.getItem('cartItemCount');
        if (storedCartItemCount) {
            $('#bagCount').text(storedCartItemCount);
        }

        // Update the cart item count dynamically
        updateCartItemCount();
    });
</script>

<script>

    // Function to handle checkout button click
    function checkout() {
            alert('Redirecting to checkout page...'); // Example: Replace with actual checkout logic
            // Add your checkout logic here, e.g., redirect to checkout page
            // window.location.href = 'checkout.php';
        }
        
        // JavaScript function to handle checkbox clicks and update total
$(document).ready(function() {
    // Add event listener for checkbox changes
    $('.cart-checkbox').change(function() {
        updateTotalAmount(); // Update total amount when checkboxes change
    });

    // Add event listener for quantity input changes
    $('.quantity-input').on('input', function() {
        updateSubtotal(this); // Update subtotal when quantity input changes
        updateTotalAmount(); // Update total amount when quantity changes
    });
});

// Function to update the total amount based on selected items and their quantities
function updateTotalAmount() {
    var total = 0;

    // Iterate through each row in the table body
    document.querySelectorAll('.cart-checkbox').forEach(function(checkbox) {
        if (checkbox.checked) {
            var row = checkbox.closest('tr');
            var subtotalText = row.querySelector('.subtotal-cell').textContent.trim().replace(/[^\d.]/g, '');
            var subtotalValue = parseFloat(subtotalText);

            if (!isNaN(subtotalValue)) {
                total += subtotalValue;
            }
        }
    });

    // Format the total amount with currency symbol (₱) and thousand separators
    var formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    });
    var formattedTotal = formatter.format(total);

    // Update the total amount in the footer
    document.getElementById('totalAmount').textContent = formattedTotal;
}

$(document).ready(function() {
  // Event listener for remove button clicks
  $('.remove-item-btn').click(function() {
      var productId = $(this).closest('td').data('product-id');
      
      // AJAX request to remove item from cart
      $.ajax({
          type: 'POST',
          url: 'removeFromCart.php', // Replace 'removeFromCart.php' with your server-side script
          data: { productId: productId },
          success: function(response) {
              // Handle success response
              alert('Item removed from cart.');
              // Reload the page or update the cart dynamically
              location.reload(); // You can replace this with more sophisticated logic
          },
          error: function(xhr, status, error) {
              // Handle error
              console.error('Error removing item:', error);
              alert('Failed to remove item from cart. Please try again.');
          }
      });
  });
});

    </script>

    <script>
        <tr>
    <td colspan="7" align="right">
        <button class="btn btn-primary checkout-btn" onclick="checkout()">Checkout</button>
    </td>
</tr>
</script>

<script>
        // JavaScript function to handle checkout button click
        function checkout() {
            var selectedItems = document.querySelectorAll('.cart-checkbox:checked');
            if (selectedItems.length === 0) {
                alert('Please select at least one item to proceed to checkout.');
            } else {
                window.location.href='checkout.php';
            }
        }
    </script>
</body>
</html>
