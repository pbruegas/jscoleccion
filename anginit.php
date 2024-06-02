<?php
session_start();

// Admin credentials
$admin_email = 'jscolleccion0@gmail.com';
$admin_hashed_password = '$2y$10$YOUR_PRECOMPUTED_HASH_HERE'; // Replace with the actual precomputed hash

if (isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true) {
    header('Location: dashboard.php'); // Redirect if already logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'admin_email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'admin_pass', FILTER_SANITIZE_STRING);

    if ($email === $admin_email && password_verify($password, $admin_hashed_password)) {
        $_SESSION['adminLogin'] = true;
        $_SESSION['admin_email'] = $email; // Store admin email in session
        header('Location: dashboard.php');
        exit();
    } else {
        echo '<script>alert("Login Failed - Invalid Credentials!");</script>';
    }
}
?>

<?php
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="styles.css">
    <title>Admin</title>
</head>
<body>
    <div class="login">
        <img src="./login-bg.jpg" alt="image" class="login__bg">
        <form action="admin.php" method="POST" class="login__form">
            <h1 class="login__title">Login</h1>
            <div class="login__inputs">
                <div class="login__box">
                    <input type="email" name="admin_email" placeholder="Email ID" required class="login__input">
                    <i class="ri-mail-fill"></i>
                </div>
                <div class="login__box">
                    <input type="password" name="admin_pass" placeholder="Password" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>
            </div>
            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" class="login__check-input" id="user-check">
                    <label for="user-check" class="login__check-label">Remember me</label>
                </div>
                <a href="#" class="login__forgot">Forgot Password?</a>
            </div>
            <button type="submit" class="login__button">Login</button>
        </form>
    </div>
</body>
</html>
