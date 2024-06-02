function fetchSearchResults(query) {
    $.ajax({
        type: 'POST',
        url: 'searchProducts.php', // Replace 'searchProducts.php' with your server-side script
        data: { query: query },
        success: function(response) {
            $('#searchResults').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching search results:', error);
        }
    });
}
