<?php
include('conn.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $searchQuery = $_POST['query'];

    // Prepare SQL query to fetch products matching the search query
    $query = "SELECT * FROM `newarrival` WHERE `arriv_name` LIKE '%$searchQuery%'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($con));
    }

    // Display search results
    if (mysqli_num_rows($result) > 0) {
        while ($product = mysqli_fetch_assoc($result)) {
            echo '<div class="search-result">';
            echo "<a href=\"#\">{$product['arriv_name']}</a>";
            echo '</div>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
}
?>
