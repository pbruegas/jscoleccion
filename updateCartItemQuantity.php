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
            },
            error: function(xhr, status, error) {
                console.error('Error fetching cart item count:', error);
            }
        });
    }

    function updateCartItemCount() {
    console.log('Updating cart item count...');

    $.ajax({
        type: 'GET',
        url: 'getCartItemCount.php',
        success: function(count) {
            console.log('Received cart item count:', count);
            $('#bagCount').text(count);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching cart item count:', error);
        }
    });
}

    // Call updateCartItemCount function immediately and at regular intervals (e.g., every 30 seconds)
    $(document).ready(function() {
        updateCartItemCount(); // Update immediately on page load

        // Set interval to update cart count every 30 seconds (adjust interval as needed)
        setInterval(updateCartItemCount, 30000); // Update every 30 seconds
    });

    // AJAX call for adding product to cart
    $(document).ready(function() {
        $('.addToCartBtn').click(function() {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productPrice = $(this).data('product-price');
            var productImage = $(this).data('product-image');

            $.ajax({
                type: 'POST',
                url: 'addToCart.php',
                data: {
                    productId: productId,
                    productName: productName,
                    productPrice: productPrice,
                    productImage: productImage
                },
                success: function(response) {
                    // Parse the JSON response
                    var jsonResponse = JSON.parse(response);

                    // Check the status of the response
                    if (jsonResponse.status === 'success') {
                        alert('Product added to cart.');
                        updateCartItemCount(); // Update cart count after adding a product
                    } else {
                        alert('Failed to add product to cart: ' + jsonResponse.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding product to cart:', error);
                    alert('An error occurred while adding the product to the cart. Please try again.');
                }
            });
        });
    });
</script>
