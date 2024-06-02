<?php
include('conn.php'); // Include your database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $uname = $_POST['uname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match";
        header('Location: register.php'); // Redirect back to the registration page
        exit();
    }

    // Escape user inputs to prevent SQL injection
    $uname = mysqli_real_escape_string($con, $uname);
    $lname = mysqli_real_escape_string($con, $lname);
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO accsignup (name, lastname, email, password) VALUES ('$uname', '$lname', '$email', '$hashed_password')";

    if (mysqli_query($con, $query)) {
        $_SESSION['success_message'] = "Registration successful!";
        header('Location: login.php'); // Redirect to the login page or any other page after successful registration
        exit();
    } else {
        $_SESSION['error_message'] = "Error registering user: " . mysqli_error($con);
        header('Location: register.php'); // Redirect back to the registration page
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

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

        h1 {
            text-align: center;
            color: #d39eab;
            font-weight: bold;
            font-size: 23px;
            padding-top: 15px;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 1.5em;
            box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="checkbox"] {
            width: 80%;
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
            color: #d39eab;
            text-decoration: none;
        }

        .text-center {
            text-align: center;
        }

        /* Additional styles for error message and red input field */
        .error-message {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }

        .input-error {
            border-color: red !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Register</h1>
        
        <!-- Display error message here -->
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
            unset($_SESSION['error_message']); // Clear the error message after displaying it
        }
        ?>
        
        <form method="POST" action="register.php" id="registrationForm">
            <div class="mb-3">
                <label class="mb-2 text-muted" for="uname">Name</label>
                <input id="uname" type="text" class="form-control" name="uname" required>
            </div>

            <div class="mb-3">
                <label class="mb-2 text-muted" for="uname">Last Name</label>
                <input id="uname" type="text" class="form-control" name="lname" required>
            </div>

            <div class="mb-3">
                <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="mb-2 text-muted" for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label class="mb-2 text-muted" for="confirm_password">Confirm Password</label>
                <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>
                <p id="passwordMatchError" class="error-message"></p> <!-- Error message for password mismatch -->
            </div>

            <p class="form-text text-muted mb-3">
                By registering you agree with our terms and conditions.
            </p>

            <div class="align-items-center d-flex">
                <button type="submit" class="submit-button">
                    Register
                </button>
            </div>

            <div class="card-footer py-3 border-0">
                    <div class="text-center">
                        Already have an account? <a href="login.php" class="text-dark">Login</a>
            </div>
        </form>
    </div>
</body>
</html>