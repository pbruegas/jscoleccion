<?php
session_start();
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
    <style>
      *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
      }
      body{
        font-family: "Poppins", sans-serif;
        background: var(--white);
      }
      .contact-container{
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
      }
      .contact-left{
        display: flex;
        flex-direction: column;
        align-items: start;
        gap: 20px;
      }
      .contact-left-title h2{
        font-weight: 600;
        color: var(--salmon-pink);
        font-size: 40px;
        margin-bottom: 5px;
      }
      .contact-left-title hr{
        border: none;
        width: 120px;
        height: 5px;
        background-color: var(--salmon-pink);
        border-radius: 10px;
        margin-bottom: 20px;
      }
      .contact-input{
        width: 400px;
        height: 50px;
        border: none;
        outline: none;
        padding-left: 25px;
        font-weight: 500;
        background-color: #ffc6c6;
        border-radius: 50px;
      }
      .contact-left textarea{
        height: 140px;
        padding-top: 15px;
        border-radius: 20px;
      }
      .contact-input:focus{
        border: 2px solid #ff5456;
      }
      .contact-input::placeholder{
        color: ebony;
      }
      .contact-left button{
        display: flex;
        align-items: center;
        padding: 15px 30px;
        font-size: 16px;
        color: #fff;
        gap: 10px;
        border: none;
        border-radius: 50px;
        background: #ffa0a1;
        cursor: pointer;
      }
      .contact-right img{
        width: 500px;
      }
    </style>
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
            <a href="#" class="menu-title">Contact</a>
            </li>
      </nav>
  </header>
  <div class="contact-container">
    <form id="contactForm" action="https://api.web3forms.com/submit" method="POST" class="contact-left">
      <div class="contact-left-title">
        <h2>Contact Us</h2>
        <hr>
      </div>
      <input type="hidden" name="access_key" value="de58b95c-9df4-4986-b0ae-d8d86738aede">
      <input type="text" name="name" placeholder="Your Name" class="contact-input" required>
      <input type="email" name="email" placeholder="Your Email" class="contact-input" required>
      <textarea name="message" placeholder="Your Message" class="contact-input" required></textarea>
      <button type="submit">Submit</button>
    </form>
    <div class="contact-right">
      <img src="./assets/images/right.png">
    </div>

  </div>

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
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    contactForm.addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent default form submission

      // Fetch API to submit the form data
      fetch(contactForm.action, {
        method: 'POST',
        body: new FormData(contactForm)
      })
      .then(response => {
        if (response.ok) {
          // Form submission was successful, redirect to the home page
          window.location.href = 'index.php';
        } else {
          // Handle error response if needed
          console.error('Form submission failed:', response.statusText);
        }
      })
      .catch(error => {
        console.error('Error during form submission:', error);
      });
    });
  });
</script>

</body>
</html>