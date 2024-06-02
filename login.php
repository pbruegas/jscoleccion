<?php
session_start();
include('conn.php'); // Include database connection

// Function to handle user login
function userLogin($email, $password) {
    global $con;

    // Prepare SQL query to retrieve user data based on email
    $stmt = $con->prepare("SELECT * FROM accsignup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session and redirect to dashboard
            session_start();
            $_SESSION['adminLogin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user['name'];
            header("Location: index.php");
            exit;
        } else {
            // Password is incorrect
            return "Invalid email or password";
        }
    } else {
        // Email not found in database
        return "Invalid email or password";
    }
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Filter and sanitize input data (optional, if needed)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // No need to sanitize password since it will be used for password verification only

    // Call userLogin function to authenticate user
    $loginResult = userLogin($email, $password);

    if ($loginResult !== true) {
        $error_message = $loginResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
            background-color: #fffbff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 1.5em;
            box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
        }

        h1 {
            text-align: center;
            color: #d39eab;
            font-weight: bold;
            font-size: 23px;
            padding-top: 15px;
        }

        input[type="email"],
        input[type="password"] {
            width: 76%;
            color: rgb(38, 50, 56);
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            background: rgba(136, 126, 126, 0.04);
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            outline: none;
            box-sizing: border-box;
            border: 2px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 20px;
            margin-left: 46px;
            text-align: center;
            font-family: 'Ubuntu', sans-serif;
        }

        .submit-button {
            width: 100%;
            padding: 10px;
            background: #d39eab;
            border: 0;
            border-radius: 5em;
            font-size: 13px;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
        }

        .submit-button:hover {
            background-color: #eac9c1;
        }

        a {
            text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
            color: #eac9c1;
            text-decoration: none;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST" class="login">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            <div class="form-group">
                <button type="submit" class="submit-button">Submit</button>
            </div>
        </form>
        <div class="text-center">
            Don't have an account? <a href="register.php" class="text-dark">Create One</a>
        </div>
    </div>
</body>
</html>
