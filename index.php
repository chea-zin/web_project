<!DOCTYPE html>
<html lang="en">
<head>
<title>Home Page</title>
    <link href="assets/styles/homepage/styles.css" rel="stylesheet">
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('scroll', () => {
            let navBar = document.querySelector('nav');
            if (window.scrollY > 0) {
                navBar.style.background = 'white';
                navBar.style.boxShadow = '0 5px 20px rgba(190, 190, 190, 0.15)'
            } else {
                navBar.style.background = 'transparent';
                navBar.style.boxShadow = 'none'
            }
        })
    })
    </script>
</head>

<body>

    <?php include("components/nav.php"); ?>

    <!-- TOP -->
    <div id="home-top-container">
        <div id="home-top-wrapper">
            <div id="home-top-text">
                <h1>Welcome to eLife!</h1>
                <?php if (isset($_SESSION['name'])): ?>
                <h2>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
                <?php endif; ?>
                <h1>
                    Track Your Steps With Quality Smartwatch
                </h1>
                <a href="products.php" class="blue-button">
                    Shop Now
                </a>

            </div>
            <div id="home-top-image">
                <img src="assets/images/topwatch.png" alt="Large Blue Smartwatch">
            </div>
        </div>
    </div>

    <!-- OUR COLLECTION/ TYPES OF PRODUCTS SELLING -->
    <div id="collection-container">
        <h1>Our Collection</h1>
        <div id="collection-items-wrapper">
            <div class="collection-item">
                <div class="collection-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-headphones" viewBox="0 0 16 16">
                        <path
                            d="M8 3a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V8a6 6 0 1 1 12 0v5a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1V8a5 5 0 0 0-5-5" />
                    </svg>
                </div>
                <span class="collection-name">
                    Headphone
                </span>
            </div>
            <div class="collection-item">
                <div class="collection-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-phone" viewBox="0 0 16 16">
                        <path
                            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                    </svg>
                </div>
                <span class="collection-name">
                    Phone
                </span>
            </div>
            <div class="collection-item">
                <div class="collection-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-smartwatch" viewBox="0 0 16 16">
                        <path d="M9 5a.5.5 0 0 0-1 0v3H6a.5.5 0 0 0 0 1h2.5a.5.5 0 0 0 .5-.5z" />
                        <path
                            d="M4 1.667v.383A2.5 2.5 0 0 0 2 4.5v7a2.5 2.5 0 0 0 2 2.45v.383C4 15.253 4.746 16 5.667 16h4.666c.92 0 1.667-.746 1.667-1.667v-.383a2.5 2.5 0 0 0 2-2.45V8h.5a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5H14v-.5a2.5 2.5 0 0 0-2-2.45v-.383C12 .747 11.254 0 10.333 0H5.667C4.747 0 4 .746 4 1.667M4.5 3h7A1.5 1.5 0 0 1 13 4.5v7a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 11.5v-7A1.5 1.5 0 0 1 4.5 3" />
                    </svg>
                </div>
                <span class="collection-name">
                    Smartwatch
                </span>
            </div>
        </div>
    </div> <!-- END OF PRODUCT COLLECTION-->

    <!-- BEST SELLERS – PRODUCT SECTION -->
    <div class="product-section-container">
        <h1>Best Sellers</h1>
        <span class="product-section-description">
            Lectus sapien auctor tortor quis pharetra ligula sapien eu augue. Praesent bibendum sapien ut
            est venenatis semper.
        </span>
        <ul class="product-section-items-wrapper">
            <li class="product-item">
                <div class="product-image">
                    <img src="assets/images/collection/watch.png" alt="Torquoise SmartWatch">
                </div>
                <div class="product-text">
                    <span class="product-title">
                        Turquoise Light Blue<br>
                        Single Wool Smartwatch
                    </span>
                    <span class="product-price">
                        $300.00
                    </span>
                </div>
            </li>
            <li class="product-item">
                <div class="product-image">
                    <img src="assets/images/collection/phone.png" alt="Torquoise SmartWatch">
                </div>
                <div class="product-text">
                    <span class="product-title">
                        Sunshine Yellow Bright Curve-Edged Tablet
                    </span>
                    <span class="product-price">
                        $200.00
                    </span>
                </div>
            </li>
            <li class="product-item">
                <div class="product-image">
                    <img src="assets/images/collection/headphone.png" alt="Sunshine Yellow Bright">
                </div>
                <div class="product-text">
                    <span class="product-title">
                        Candyfloss Pink Two-Earpiece Headphone
                    </span>
                    <span class="product-price">
                        $500.00
                    </span>
                </div>
            </li>
        </ul>
    </div> <!-- END OF BEST SELLERS - PRODUCT SECTION -->

    <!-- IPAD PROMO -->
    <div class="promo-container">
        <div class="promo-box">
            <div class="promo-image">
                <img src="assets/images/collection/ipad.png" alt="Candyfloss Pink Two-Earpiece Headphone">
            </div>
            <div class="promo-content">
                <h1>New Arrivals</h1>
                <h2>Sunshine Ipad</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Curabitur tristique quam eget eros convallis,
                    sit amet pellentesque.
                </p>
                <button class="white-button" onclick="window.location.href='products.php';">
                    SHOP NOW
                </button>
            </div>
        </div>
    </div> <!-- END OF IPAD PROMO -->
</body>
<?php include("components/footer.php"); ?>

</html>