'use strict';

// modal variables
const modal = document.querySelector('[data-modal]');
const modalCloseBtn = document.querySelector('[data-modal-close]');
const modalCloseOverlay = document.querySelector('[data-modal-overlay]');

// modal function
const modalCloseFunc = function () { modal.classList.add('closed') }

// modal eventListener
modalCloseOverlay.addEventListener('click', modalCloseFunc);
modalCloseBtn.addEventListener('click', modalCloseFunc);





// notification toast variables
const notificationToast = document.querySelector('[data-toast]');
const toastCloseBtn = document.querySelector('[data-toast-close]');

// notification toast eventListener
toastCloseBtn.addEventListener('click', function () {
  notificationToast.classList.add('closed');
});


// Get the buttons by their IDs
const addToCartBtn = document.getElementById('addToCartBtn');
const addToFavoritesBtn = document.getElementById('addToFavoritesBtn');

// Add event listeners for button clicks
addToCartBtn.addEventListener('click', addToCart);
addToFavoritesBtn.addEventListener('click', addToFavorites);

// Function to handle adding to cart
function addToCart() {
    // Add your logic here to add the product to the cart
    // For example, you can show a message or update a counter
    alert('Product added to cart!');
}

// Function to handle adding to favorites
function addToFavorites() {
    // Add your logic here to add the product to favorites
    // For example, you can show a message or change the button style
    alert('Product added to favorites!');
}



// mobile menu variables
const mobileMenuOpenBtn = document.querySelectorAll('[data-mobile-menu-open-btn]');
const mobileMenu = document.querySelectorAll('[data-mobile-menu]');
const mobileMenuCloseBtn = document.querySelectorAll('[data-mobile-menu-close-btn]');
const overlay = document.querySelector('[data-overlay]');

for (let i = 0; i < mobileMenuOpenBtn.length; i++) {

  // mobile menu function
  const mobileMenuCloseFunc = function () {
    mobileMenu[i].classList.remove('active');
    overlay.classList.remove('active');
  }

  mobileMenuOpenBtn[i].addEventListener('click', function () {
    mobileMenu[i].classList.add('active');
    overlay.classList.add('active');
  });

  mobileMenuCloseBtn[i].addEventListener('click', mobileMenuCloseFunc);
  overlay.addEventListener('click', mobileMenuCloseFunc);

}





// accordion variables
const accordionBtn = document.querySelectorAll('[data-accordion-btn]');
const accordion = document.querySelectorAll('[data-accordion]');

for (let i = 0; i < accordionBtn.length; i++) {

  accordionBtn[i].addEventListener('click', function () {

    const clickedBtn = this.nextElementSibling.classList.contains('active');

    for (let i = 0; i < accordion.length; i++) {

      if (clickedBtn) break;

      if (accordion[i].classList.contains('active')) {

        accordion[i].classList.remove('active');
        accordionBtn[i].classList.remove('active');

      }

    }

    this.nextElementSibling.classList.toggle('active');
    this.classList.toggle('active');

  });

}

// Function to fetch and display the latest product
function fetchAndDisplayLatestProduct() {
  // Make an AJAX request to fetch the latest product
  fetch('admin.php')
  .then(response => response.json())
  .then(data => {
      // Create HTML elements for the new product
      const productContainer = document.querySelector('.product-container');

      const newShowcase = document.createElement('div');
      newShowcase.classList.add('showcase');

      const showcaseBanner = document.createElement('div');
      showcaseBanner.classList.add('showcase-banner');

      const productImgDefault = document.createElement('img');
      productImgDefault.src = data.img_fileName; // Assuming 'img_fileName' holds the image URL
      productImgDefault.alt = data.prod_name; // Assuming 'prod_name' holds the product name
      productImgDefault.width = 300; // Assuming constant width
      productImgDefault.classList.add('product-img', 'default');

      const productImgHover = document.createElement('img');
      productImgHover.src = data.img_fileName; // Assuming 'img_fileName' holds the image URL
      productImgHover.alt = data.prod_name; // Assuming 'prod_name' holds the product name
      productImgHover.width = 300; // Assuming constant width
      productImgHover.classList.add('product-img', 'hover');

      const showcaseActions = document.createElement('div');
      showcaseActions.classList.add('showcase-actions');

      // Append images and actions to their respective containers
      showcaseBanner.appendChild(productImgDefault);
      showcaseBanner.appendChild(productImgHover);

      const showcaseContent = document.createElement('div');
      showcaseContent.classList.add('showcase-content');

      const showcaseCategory = document.createElement('a');
      showcaseCategory.href = '#'; // Link to product details
      showcaseCategory.classList.add('showcase-category');
      showcaseCategory.textContent = data.prod_category; // Assuming 'prod_category' holds the category

      const showcaseTitle = document.createElement('a');
      showcaseTitle.href = '#'; // Link to product details
      showcaseTitle.classList.add('showcase-title');
      showcaseTitle.textContent = data.prod_name; // Assuming 'prod_name' holds the product name

      const priceBox = document.createElement('div');
      priceBox.classList.add('price-box');

      const price = document.createElement('p');
      price.classList.add('price');
      price.innerHTML = '&#x20B1;' + data.prod_price; // Assuming 'prod_price' holds the price

      // Append category, title, and price to their respective containers
      showcaseContent.appendChild(showcaseCategory);
      showcaseContent.appendChild(showcaseTitle);
      priceBox.appendChild(price);
      showcaseContent.appendChild(priceBox);

      // Append banner and content to the showcase
      newShowcase.appendChild(showcaseBanner);
      newShowcase.appendChild(showcaseContent);
      productContainer.appendChild(newShowcase);
  })
  .catch(error => console.error('Error fetching latest product:', error));
}

// Call the function to fetch and display the latest product
fetchAndDisplayLatestProduct();


