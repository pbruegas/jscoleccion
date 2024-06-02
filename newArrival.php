<?php
include ('conn.php'); // Include database connection
session_start();

// Insert operation for new arrivals
if(isset($_POST['insert'])){
    // Get form data
    $category = $_POST['category'];
    $productName = $_POST['productName'];
    $availableItems = $_POST['availableItems'];
    $price = $_POST['price'];
    $image = $_FILES['imageUpload']['name'];
    $image_tmp_name = $_FILES['imageUpload']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    if(empty($category) || empty($productName) || empty($availableItems) || empty($price) || empty($image)){
        $message[] = 'Please fill out all fields.';
    }else{
        // Store image in folder and database
        move_uploaded_file($image_tmp_name, $image_folder);
        $insert = "INSERT INTO newarrival (arriv_category, arriv_imgfName, arriv_name, arriv_avItems, arriv_price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert);
        $stmt->bind_param("sssss", $category, $image, $productName, $availableItems, $price);

        if($stmt->execute()){
            $message[] = 'New product added successfully.';
            // Debugging statement
            echo "Product added successfully.";
        }else{
            $message[] = 'Could not add the product.';
            // Debugging statement
            echo "Error adding product: " . $stmt->error;
        }
    }
}

// Read operation - Fetch all new arrivals
$query = "SELECT * FROM newarrival";
$result = mysqli_query($con, $query);

// Update operation - Not implemented in this code snippet

if(isset($_POST['delete'])){
    $delete_id = $_POST['delete_id'];
    $delete_query = "DELETE FROM newarrival WHERE arriv_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    
    if($stmt->execute()){
        $message[] = 'Product deleted successfully.';
        // Redirect back to the new arrival page
        header('location: newArrival.php');
    }else{
        $message[] = 'Could not delete the product.';
        // Debugging statement
        echo "Error deleting product: " . $stmt->error;
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Users Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        *, ::after, ::before {
            box-sizing: border-box;}
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            opacity: 1;
            overflow-y: scroll;
            margin: 0;}
        a {
            cursor: pointer;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;}
        li {
            list-style: none;}
        h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.275rem;
            color: var(--bs-emphasis-color);}
        .wrapper {
            align-items: stretch;
            display: flex;
            width: 100%;}
        #sidebar {
            max-width: 264px;
            min-width: 264px;
            background: var(--bs-dark);
            transition: all 0.35s ease-in-out;}
        .main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            width: 100%;background: var(--bs-dark-bg-subtle);}
        .sidebar-logo {
            padding: 1.15rem;}
        .sidebar-logo a {
            color: #e9ecef;
            font-size: 1.15rem;
            font-weight: 600;}
        .sidebar-nav {
            flex-grow: 1;
            list-style: none;
            margin-bottom: 0;
            padding-left: 0;
            margin-left: 0;}
        .sidebar-header {
            color: #e9ecef;
            font-size: .75rem;
            padding: 1.5rem 1.5rem .375rem;}
        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #e9ecef;
            position: relative;
            display: block;
            font-size: 0.875rem;}
        .sidebar-link[data-bs-toggle="collapse"]::after {
            border: solid;
            border-width: 0 .075rem .075rem 0;
            content: "";
            display: inline-block;
            padding: 2px;
            position: absolute;
            right: 1.5rem;
            top: 1.4rem;
            transform: rotate(-135deg);
            transition: all .2s ease-out;}
        .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(45deg);
            transition: all .2s ease-out;}
        .avatar {
            height: 40px;
            width: 40px;}
        .navbar-expand .navbar-nav {
            margin-left: auto;}
        .content {
            flex: 1;
            max-width: 100vw;
            width: 100vw;}
        @media (min-width:768px) {
        .content {
            max-width: auto;
            width: auto;}}
        .card {
            box-shadow: 0 0 .875rem 0 rgba(34, 46, 60, .05);
            margin-bottom: 24px;}
        .illustration {
            background-color: var(--bs-primary-bg-subtle);
            color: var(--bs-emphasis-color);}
        .illustration-img {
            max-width: 150px;
            width: 100%;}
        #sidebar.collapsed {
            margin-left: -264px;}
        @media (max-width:767.98px) {
            .js-sidebar {
                margin-left: -264px;}
            #sidebar.collapsed {
                margin-left: 0;}
            .navbar, footer {
                width: 100vw;}}
.theme-toggle {
    position: fixed;
    top: 50%;
    transform: translateY(-65%);
    text-align: center;
    z-index: 10;
    right: 0;
    left: auto;
    border: none;
    background-color: var(--bs-body-color);
}

html[data-bs-theme="dark"] .theme-toggle .fa-sun,
html[data-bs-theme="light"] .theme-toggle .fa-moon {
    cursor: pointer;
    padding: 10px;
    display: block;
    font-size: 1.25rem;
    color: #FFF;
}

html[data-bs-theme="dark"] .theme-toggle .fa-moon {
    display: none;
}

html[data-bs-theme="light"] .theme-toggle .fa-sun {
    display: none;
}

/* Custom CSS for table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
}

th, td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
    text-align: left;
}

th {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 600;
}

tbody tr:nth-of-type(even) {
    background-color: #f8f9fa;
}

tbody tr:hover {
    background-color: #e9ecef;
}

/* Add User Form styling */
.container {
    margin-top: 1.5rem;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.container h6 {
    margin-bottom: 0.5rem;
    font-size: 1rem;
    color: #212529;
}

.container input[type="text"],
.container input[type="email"],
.container input[type="password"] {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    border: 1px solid #ced4da;
    border-radius: 3px;
}

.container button[type="submit"] {
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.container button[type="submit"]:hover {
    background-color: #0056b3;
}

/* CSS for the edit form */
.edit-form {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.edit-form .form-group {
    margin-bottom: 15px;
}

/* CSS for the message box */
.message-box {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.edit-form-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 400px;
    margin: auto;
}

.edit-form-container h4 {
    margin-bottom: 10px;
}

.edit-form-container label {
    display: block;
    margin-bottom: 5px;
}

.edit-form-container input[type="text"],
.edit-form-container input[type="email"],
.edit-form-container button {
    margin-top: 10px;
    width: 100%;
}

.edit-form-container button {
    margin-top: 20px;
}

body {
    overflow: auto; /* Prevent scrolling while the form is open */
}

.edit-form {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.edit-form-container {
    text-align: center;
}

.edit-form-buttons {
    margin-top: 20px;
}

/* CSS styles (omitted for brevity) */
.small-image {
            max-width: 100px;
            height: 100px;
}

    </style>

</head>
<body>
<div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">Admin Panel</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Admin Elements
                    </li>
                    <li class="sidebar-item">
                        <a href="admin.php" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="crud.php" class="sidebar-link">
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Users
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="products.php" class="sidebar-link">
                            <i class="fa-regular fa-user pe-2"></i>
                            Products
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="newArrival.php" class="sidebar-link">
                            <i class="fa-regular fa-user pe-2"></i>
                            New Arrival
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="addedToCart.php" class="sidebar-link">
                            <i class="fa-regular fa-user pe-2"></i>
                            Cart Items
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="favorites.php" class="sidebar-link">
                            <i class="fa-regular fa-user pe-2"></i>
                            Favorites
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="main">
            <!-- Main Content Goes Here -->
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="profile.jpg" class="avatar img-fluid rounded" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="anginit.php" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Admin Dashboard</h4>

                        <div class="container">
        
                 <!-- Form to add new arrival -->
    <form id="addNewArrivalForm" action="newArrival.php" method="post" enctype="multipart/form-data">
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br><br>

        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required><br><br>

        <label for="availableItems">Available Items:</label>
        <input type="text" id="availableItems" name="availableItems" required><br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br><br>

        <label for="imageUpload">Image:</label>
        <input type="file" id="imageUpload" name="imageUpload" accept="image/*" required><br><br>

        <button type="submit" name="insert">Add New Arrival</button>
    </form>

    <!-- Table Element -->
<div class="card border-0">
    <div class="card-header">
        <h5 class="card-title">
            New Arrival Products Table
        </h5>
    </div>
    <div class="card-body">
        <table id="arrivalTable" class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Available Items</th>
                    <th>Price</th>
                    <th>Action</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch new arrival products from the database
                $select = "SELECT * FROM `newarrival`";
                $result = mysqli_query($con, $select);

                // Check if there are any new arrival products
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['arriv_category'] . "</td>";
                        echo "<td><img src='uploaded_img/" . $row['arriv_imgfName'] . "' class='small-image'></td>";
                        echo "<td>" . $row['arriv_name'] . "</td>";
                        echo "<td>" . $row['arriv_avItems'] . "</td>";
                        echo "<td>" . $row['arriv_price'] . "</td>";
                        echo "<td>
                            <a href='javascript:void(0);' onclick='openEditForm(" . $row['arriv_id'] . ")' class='btn btn-primary'>Edit</a>
                            <form method='post' action='newArrival.php' style='display: inline;'>
    <input type='hidden' name='delete_id' value='" . $row['arriv_id'] . "'>
    <button type='submit' name='delete' class='btn' style='background-color: #dc3545; color: #fff;'>Delete</button>
</form>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No new arrival products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Edit Form -->
<div id="editForm" class="edit-form" style="display: none;">
    <div class="edit-form-container">
        <h4>Edit Product</h4>
        <form id="editProductForm" action="products.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="editCategory">Category:</label>
                <input type="text" id="editCategory" name="editCategory" required>
            </div>
            <div class="form-group">
                <label for="editProductName">Product Name:</label>
                <input type="text" id="editProductName" name="editProductName" required>
            </div>
            <div class="form-group">
                <label for="editAvailableItems">Available Items:</label>
                <input type="text" id="editAvailableItems" name="editAvailableItems" required>
            </div>
            <div class="form-group">
                <label for="editPrice">Price:</label>
                <input type="text" id="editPrice" name="editPrice" required>
            </div>
            <div class="form-group">
                <label for="editImageUpload">Image:</label>
                <input type="file" id="editImageUpload" name="editImageUpload" accept="image/*">
            </div>
            <input type="hidden" id="editProductId" name="editProductId">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<script>
    // Function to open the edit form with pre-filled data
    function openEditForm(productId) {
        // Get product details from the table
        const category = document.getElementById('category' + productId).innerText;
        const productName = document.getElementById('productName' + productId).innerText;
        const availableItems = document.getElementById('availableItems' + productId).innerText;
        const price = document.getElementById('price' + productId).innerText;

        // Set values in the edit form
        document.getElementById('editCategory').value = category;
        document.getElementById('editProductName').value = productName;
        document.getElementById('editAvailableItems').value = availableItems;
        document.getElementById('editPrice').value = price;
        document.getElementById('editProductId').value = productId;

        // Show the edit form
        document.getElementById('editForm').style.display = 'block';
    }
</script>

    <!-- Bootstrap JS and Custom Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="adscript.js"></script>
    <script src="prodEdit.js"></script>

</body>
</html>
