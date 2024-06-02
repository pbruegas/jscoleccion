function openEditForm(productId) {
    // Get product details from the table
    const category = document.getElementById('category_' + productId).innerText;
    const productName = document.getElementById('productName_' + productId).innerText;
    const availableItems = document.getElementById('availableItems_' + productId).innerText;
    const price = document.getElementById('price_' + productId).innerText;

    // Set values in the edit form
    document.getElementById('editCategory').value = category;
    document.getElementById('editProductName').value = productName;
    document.getElementById('editAvailableItems').value = availableItems;
    document.getElementById('editPrice').value = price;
    document.getElementById('editProductId').value = productId;

    // Show the edit form
    const editForm = document.querySelector('.edit-form');
    editForm.style.display = 'block';
}


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
