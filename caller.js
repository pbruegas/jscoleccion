function fetchLatestProducts() {
    // Make an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_latest_products.php", true); // Assuming PHP script name is fetch_latest_products.php
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var products = JSON.parse(xhr.responseText);
            displayLatestProducts(products);
        }
    };
    xhr.send();
}

function displayLatestProducts(products) {
    var container = document.getElementById("productsContainer");
    container.innerHTML = ""; // Clear previous content

    products.forEach(function (product) {
        var productHTML = `
            <div class="product">
                <img src="${product.img_fileName}" alt="${product.prod_name}" class="product-img">
                <div class="product-details">
                    <h2>${product.prod_name}</h2>
                    <p>Price: $${product.price}</p>
                    <p>Description: ${product.description}</p>
                    <!-- Add more details as needed -->
                </div>
            </div>`;
        container.innerHTML += productHTML;
    });
}