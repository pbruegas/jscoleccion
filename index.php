<?php
session_start();
include('conn.php'); // Include database connection

// Fetch products from the database
$query = "SELECT * FROM `newarrival`";
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
                        <a href="#" class="menu-title">Home</a>
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
    <main>
        <div class="banner">
            <div class="container">
                <div class="slider-container has-scrollbar">
                    <div class="slider-item">
                        <img src="./assets/images/ban-1.png" alt="women's latest fashion sale" class="banner-img">
                    </div>
                    <div class="slider-item">
                        <img src="./assets/images/banner-2.png" alt="new fashion summer sale" class="banner-img">
                    </div>
                </div>
            </div>
        </div>
        <div class="product-container">
            <div class="container">
                <div class="product-box">
                    <div class="product-main">
                        <h2 class="title">New Arrivals</h2>
                        <div class="product-grid" id="productGrid">

                            <?php
                            // Check if there are products in the database
                            if (mysqli_num_rows($result) > 0) {
                                while ($product = mysqli_fetch_assoc($result)) {
                                    echo '<div class="showcase">';
                                    echo '<div class="showcase-banner">';
                                    $imagePath = "./assets/images/products/{$product['arriv_imgfName']}";
                                    echo "<img src=\"{$imagePath}\" alt=\"{$product['arriv_name']}\" width=\"300\" class=\"product-img default\">";
                                    echo "<img src=\"{$imagePath}\" alt=\"{$product['arriv_name']}\" width=\"300\" class=\"product-img hover\">";
                                    
                                    // Display "NEW" badge if the product is new
                                    if ($product['arriv_avItems'] > 0) {
                                        echo '<p class="showcase-badge angle black">NEW</p>';
                                    }
                                    
                                    echo '<div class="showcase-actions">';
                                //echo '<button class="btn-action"><ion-icon name="heart-outline"></ion-icon></button>';
                                    //echo '<button class="btn-action"><ion-icon name="bag-add-outline"></ion-icon></button>';
                                    echo '</div>'; // Close .showcase-actions
                                    echo '</div>'; // Close .showcase-banner
                                    echo '<div class="showcase-content">';
                                    echo "<a href=\"#\" class=\"showcase-category\">{$product['arriv_category']}</a>";
                                    echo "<a href=\"#\"><h3 class=\"showcase-title\">{$product['arriv_name']}</h3></a>";
                                    echo '<div class="price-box">';
                                    echo "<p class=\"price\">&#x20B1;{$product['arriv_price']}</p>";
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




    <script src="./script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
