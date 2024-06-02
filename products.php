<?php
session_start();
include('conn.php'); // Include database connection

// Fetch the search query if it is set
$searchQuery = isset($_GET['query']) ? mysqli_real_escape_string($con, $_GET['query']) : '';

// Fetch products from the database
if ($searchQuery) {
    $query = "SELECT * FROM products WHERE prod_name LIKE '%$searchQuery%' OR prod_category LIKE '%$searchQuery%'";
} else {
    $query = "SELECT * FROM products";
}
$result = mysqli_query($con, $query);

// Check for errors
if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JS Coleccion</title>
    <link rel="stylesheet" href="./style-prefix.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>

<body>
    <header>
        <div class="header-main">
            <div class="container">
                <a href="index.php" class="header-logo">
                    <img src="./logo.png" alt="logo" width="120" height="36">
                </a>

                <div class="header-search-container">
                    <form id="searchForm" method="GET" action="products.php">
                        <input type="search" name="query" class="search-field" placeholder="Search" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                        <button type="submit" class="search-btn">
                        <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </form>
                </div>

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
            </div>
        </nav>
    </header>
    <main>
        <div class="product-container">
            <div class="container">
                <div class="product-box">

                    <div class="product-main">

                        <h2 class="title">Products</h2>

                        <div class="product-grid" id="productGrid">

                            <?php
                            // Check if there are products in the database
                            if (mysqli_num_rows($result) > 0) {
                                while ($product = mysqli_fetch_assoc($result)) {
                                    echo '<div class="showcase">';
                                    echo '<div class="showcase-banner">';
                                    // Assuming $product['img_fileName'] contains the image filename with the folder structure
                                    $imageName = $product['img_fileName'];
                                    $imageName = str_replace("uploaded_img/", "", $imageName); // Remove the folder structure
                                    $imagePath = "./assets/images/{$imageName}";
                                    $imagePath = "./assets/images/products/{$product['img_fileName']}";
                                    echo "<img src=\"{$imagePath}\" {$product['img_fileName']}\" alt=\"{$product['prod_name']}\" width=\"300\" class=\"product-img default\">";
                                    echo "<img src=\"{$imagePath}\" {$product['img_fileName']}\" alt=\"{$product['prod_name']}\" width=\"300\" class=\"product-img hover\">";
                                    echo '<div class="showcase-actions">';
                                    echo '<button class="btn-action addToCartBtn" 
                    data-product-id="' . $product['prod_id'] . '"
                    data-product-name="' . htmlspecialchars($product['prod_name'], ENT_QUOTES) . '"
                    data-product-price="' . $product['prod_price'] . '"
                    data-product-image="' . $imagePath . '">
                    <ion-icon name="bag-add-outline"></ion-icon>
              </button>';
        
                                    echo '</div>'; // Close .showcase-actions
                                    echo '</div>'; // Close .showcase-banner
                                    echo '<div class="showcase-content">';
                                    echo "<a href=\"#\" class=\"showcase-category\">{$product['prod_category']}</a>";
                                    echo "<a href=\"#\"><h3 class=\"showcase-title\">{$product['prod_name']}</h3></a>";
                                    echo '<div class="price-box">';
                                    echo "<p class=\"price\">&#x20B1;{$product['prod_price']}</p>";
                                    echo '</div>'; // Close .price-box
                                    echo '</div>'; // Close .showcase-content
                                    echo '</div>'; // Close .showcase
                                }
                            } else {
                                echo "<p>No products found.</p>";
                            }
                            ?>

                        </div> <!-- Close .product-grid -->

                    </div> <!-- Close .product-main -->

                </div> <!-- Close .product-box -->

            </div> <!-- Close .container -->

        </div> <!-- Close .product-container -->
    </main>

    <script>
        // Fetch products and dynamically display them
        window.addEventListener('DOMContentLoaded', () => {
            fetch('fetch_products.php') // PHP file to fetch products from the database
                .then(response => response.json())
                .then(data => {
                    const productGrid = document.getElementById('productGrid');
                    data.forEach(product => {
                        const productHTML = `
                            <div class="showcase">
                                <div class="showcase-banner">
                                    <img src="${product.img_fileName}" alt="${product.prod_name}" width="300" class="product-img default">
                                    <div class="showcase-actions">
                                        <button class="btn-action">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </button>
                                        <button class="btn-action">
                                            <ion-icon name="bag-add-outline"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="showcase-content">
                                    <a href="#" class="showcase-category">${product.prod_category}</a>
                                    <a href="#">
                                        <h3 class="showcase-title">${product.prod_name}</h3>
                                    </a>
                                    <div class="price-box">
                                        <p class="price">&#x20B1;${product.price}</p>
                                    </div>
                                </div>
                            </div>`;
                        productGrid.innerHTML += productHTML;
                    });
                })
                .catch(error => console.error('Error fetching products:', error));
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
            },
            error: function(xhr, status, error) {
                console.error('Error fetching cart item count:', error);
            }
        });
    }

    // Call updateCartItemCount function on page load
    updateCartItemCount();

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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="./script.js"></script>
    <script type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</body>

</html>
