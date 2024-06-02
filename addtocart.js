document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.addToBagBtn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default link behavior

            // Extract product information from the button's data attributes
            const productContainer = button.closest('.showcase');
            const productId = productContainer.getAttribute('data-product-id');
            const productName = productContainer.querySelector('.showcase-title').innerText;
            const productPrice = productContainer.querySelector('.price').innerText;
            const productImage = productContainer.querySelector('.product-img').getAttribute('src');

            // Send AJAX request to addToCart.php
            fetch('addToCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productId: productId,
                    productName: productName,
                    productPrice: productPrice,
                    productImage: productImage
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update the cart count
                    const cartCountElement = document.getElementById('bagCount');
                    const currentCount = parseInt(cartCountElement.innerText);
                    cartCountElement.innerText = currentCount + 1;

                    // Show a success message to the user
                    alert('Product added to cart.');
                } else {
                    // Show an error message to the user
                    console.error('Error adding product to cart:', data.message);
                    alert('Error adding product to cart. Please check console for details.');
                }
            })
            .catch(error => {
                console.error('Error adding item to cart:', error);
                alert('Error adding product to cart. Please check console for details.');
            });
        });
    });
});
