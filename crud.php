<?php 
include ('conn.php');
session_start();

// Insert operation
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['insert'])) {
    $uname = $_POST['uname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Escape user inputs to prevent SQL injection
    $uname = mysqli_real_escape_string($con, $uname);
    $lname = mysqli_real_escape_string($con, $lname);
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO accsignup (name, lastname, email, password) VALUES ('$uname', '$lname', '$email', '$hashed_password')";

    if (mysqli_query($con, $query)) {
        $_SESSION['success_message'] = "User added successfully!";
        header('Location: crud.php'); // Redirect to the CRUD page after insertion
        exit();
    } else {
        $_SESSION['error_message'] = "Error adding user: " . mysqli_error($con);
    }
}

// Read operation - Fetch all users
$query = "SELECT * FROM accsignup ORDER BY id DESC";
$result = mysqli_query($con, $query);

// Update operation
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $userid = $_POST['userid'];
    $newName = $_POST['new_name'];
    $newlastName = $_POST['new_lastname'];
    $newEmail = $_POST['new_email'];

    $updateQuery = "UPDATE accsignup SET name='$newName', lastname='$newlastName', email='$newEmail' WHERE id='$userid'";
    if (mysqli_query($con, $updateQuery)) {
        $_SESSION['success_message'] = "User updated successfully!";
        echo json_encode(['success' => true, 'message' => 'User updated successfully']);
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating user: " . mysqli_error($con);
        echo json_encode(['success' => false, 'message' => 'Error updating user']);
        exit();
    }
}

// Delete operation
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $userid = $_POST['userid'];

    $deleteQuery = "DELETE FROM accsignup WHERE id='$userid'";
    if (mysqli_query($con, $deleteQuery)) {
        $_SESSION['success_message'] = "User deleted successfully!";
        header('Location: crud.php'); // Redirect after deletion
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting user: " . mysqli_error($con);
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
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Users Table
                            </h5>
                            <h6 class="card-subtitle text-muted">
                                Users of JS Collection
                            </h6>
                        </div>
                        <div class="card-body">
                        <table>
    <tr>
        <th>Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr id="row-<?php echo $row['id']; ?>">
                                    <td><?php echo $row['name']; ?></td>
                                    <td class="last-name"><?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td>
                                        <!-- Button to display edit form -->
                                        <button onclick="showEditForm(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['email']; ?>')">Edit</button>
                                        <!-- Form for delete operation -->
                                        <form method="POST" action="crud.php" style="display: inline;">
                                            <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete" style="margin-left: 5px;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <div class="container">
                                <h6>Add New User</h6>
                                <form method="POST" action="crud.php">
                                    <input type="text" name="uname" placeholder="Name" required>
                                    <input type="text" name="lname" placeholder="Last Name" required>
                                    <input type="email" name="email" placeholder="Email" required>
                                    <input type="password" name="password" placeholder="Password" required>
                                    <button type="submit" name="insert">Add User</button>
                                </form>
                            </div>
                        </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Display success or error messages if any -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="message-box"><?php echo $_SESSION['success_message']; ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="message-box"><?php echo $_SESSION['error_message']; ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <script>
        // JavaScript to fade out the message box after a certain time
        const messageBox = document.querySelector('.message-box');
        if (messageBox) {
            setTimeout(() => {
                messageBox.style.opacity = '0';
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 500);
            }, 3000); // Fade out after 3 seconds
        }

        // Function to show edit form
        function showEditForm(userId, name, lastname, email) {
            // Your code to display an edit form or modal with user details for editing
        }
    </script>

    <!-- Include JavaScript for edit form -->
    <script>
        // Function to show edit form
    function showEditForm(userId, name, lastname, email) {
        const editForm = document.createElement('form');
        editForm.classList.add('edit-form');
        editForm.innerHTML = `
            <div class="edit-form-container">
                <h4>Edit User</h4>
                <label for="new_name">Name:</label>
                <input type="text" id="new_name" name="new_name" value="${name}" required>
                <label for="new_lastname">Last Name:</label>
                <input type="text" id="new_lastname" name="new_lastname" value="${lastname}" required>
                <label for="new_email">Email:</label>
                <input type="email" id="new_email" name="new_email" value="${email}" required>
                <div class="edit-form-buttons">
                    <button type="button" onclick="updateUser(${userId})">Update</button>
                    <button type="button" onclick="cancelEdit()">Cancel</button>
                </div>
            </div>
        `;

        // Append the edit form to the main content
        const mainContent = document.querySelector('.content');
        mainContent.appendChild(editForm);
    }

    // Function to cancel edit form
    function cancelEdit() {
        const editForm = document.querySelector('.edit-form');
        if (editForm) {
            editForm.remove();
        }
    }

    // Function to update user data
    function updateUser(userId) {
        // Get the updated values from the form fields
        const newName = document.getElementById('new_name').value;
        const newLastName = document.getElementById('new_lastname').value;
        const newEmail = document.getElementById('new_email').value;

        // Send a POST request to the server to update the user's information
        fetch('crud.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `update=true&userid=${userId}&new_name=${encodeURIComponent(newName)}&new_lastname=${encodeURIComponent(newLastName)}&new_email=${encodeURIComponent(newEmail)}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display success message
                alert(data.message);
                
                // Update the table row with the new data
                const lastNameCell = document.querySelector(`#row-${userId} .last-name`);
                if (lastNameCell) {
                    lastNameCell.textContent = newLastName;
                }

                // Clear the edit form
                cancelEdit();
            } else {
                // Display error message
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>

    <!-- Bootstrap JS and Custom Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="adscript.js"></script>

</body>
</html>