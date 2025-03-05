
<!-- MOBILE PHONE SECTION -->
<div class="product-section" id="product-section-mobile">
    <div class="product-section-top-container">
        <div class="section-category-container">
            <div class="section-category-type">
                <span class="blue-line"></span>
                <span class="section-category-text">Watches</span>
            </div>
            <h1>Discover Our Smartwatches</h1>
        </div>
    </div>
    <div class="product-cards-container" id="product-cards-container3">
        <!-- Product cards will be inserted here via JavaScript -->
    </div>
</div>
 <!-- END OF MOBILE PHONES COLLECTION -->
 <style>

 </style>
 <script>
// Array of product data
const watchProducts = [{
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/01.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/02.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/03.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/04.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/05.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/06.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/07.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/08.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/09.png",
        altText: "Sandy Phone"
    },
    {
        name: "Sandy Phone",
        price: "$135.99",
        imageSrc: "assets/images/product-page/smartwatch/10.png",
        altText: "Sandy Phone"
    }
];

// Function to generate and insert product cards
function generateProductCards() {
    const productCardsContainer = document.getElementById('product-cards-container3');

    watchProducts.forEach(product => {
        const productCard = document.createElement('li');
        productCard.classList.add('product-card');

        productCard.innerHTML = `
            <div class="product-image-container">
                <img src="${product.imageSrc}" alt="${product.altText}">
                <button class="heart-button">
                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
            <div class="product-text-container">
                <h1>${product.name}</h1>
                <p>${product.price}</p>
                <button class="blue-button">Add To Cart</button>
            </div>
        `;

        productCardsContainer.appendChild(productCard);
    });
}

// Call the function to generate the cards
generateProductCards();
 </script>