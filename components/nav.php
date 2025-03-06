<?php
session_start();
include("connections/db.php");
include("logic/get_cart_count.php");
$cartItemCount = 0;
$user = null;

// Function to get the cart item count
function getCartItemCount($pdo, $user_id = null) {
    if ($user_id) {
        $countCartItemsStmt = $pdo->prepare("SELECT SUM(quantity) AS total_items FROM user_cart WHERE user_id = :user_id");
        $countCartItemsStmt->execute([':user_id' => $user_id]);
        $cartItemCount = $countCartItemsStmt->fetch(PDO::FETCH_ASSOC)['total_items'] ?? 0;
        return $cartItemCount;
    }
    return 0; // Or handle the case when the user is not logged in appropriately
}

// Check if the user is logged in
if (isset($_SESSION['name'])) {
    // Fetch the logged-in user's ID
    $stmt = $pdo->prepare("SELECT id FROM users WHERE name = :name");
    $stmt->bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id'];
        $cartItemCount = getCartItemCount($pdo, $user_id);
    }
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<nav>
    <div id="navbar">
        <div id="navbar-logo">
            <img src="assets/images/eLife.png" width="140" height="70" alt="Logo">
        </div>
        <div id="navbar-links" class="hidden">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="checkout.php">Checkout</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </div>
        <div class="container">
            <!-- Cart Button -->
            <button id="mycart" type="button" class="mycart-button" onclick="toggleCart()">
                <span id="cart-count" class="cart-count">
                    <?php echo $cartItemCount; ?>
                </span>
                <i class="fa-solid fa-bag-shopping"></i>
            </button>

            <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button" class="dropdown-button">
                <i class="fa-solid fa-user"></i>
            </button>

            <div id="userDropdown1" class="dropdown hidden">
                <ul class="dropdown-list">
                    <?php if (isset($_SESSION['name'])): ?>
                    <li><a href="profile.php" class="dropdown-item">
                            <i class="fa-regular fa-user"></i>
                            My Account </a></li>
                    <li><a href="#" class="dropdown-item">
                            <i class="fa-solid fa-receipt"></i>
                            My Orders </a></li>
                    <li><a href="logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out"></i>
                            Sign Out
                        </a></li>
                    <?php else: ?>
                    <li><a href="register.php" class="dropdown-item"> Register</a></li>
                    <li><a href="login.php" class="dropdown-item"> Login </a></li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
        <div id="hamburger" class="hamburger">
            ☰
        </div>
    </div>
</nav>
<!-- Sidebar Cart -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h3>My Cart</h3>
        <button onclick="toggleCart()" class="close-btn"></button>
    </div>
    <div class="cart-content">
        <p>Your cart is empty</p>
        <!-- Dynamic cart items will be inserted here -->
    </div>
    <div class="cart-footer">
        <button class="checkout-btn">Proceed to Checkout</button>
    </div>
</div>

<style>
nav {
    position: fixed;
    /* Fix the navbar at the top */
    top: 0;
    left: 0;
    width: 100%;
    /* Full width */
    background-color: white;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

#navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    padding-left: 108px;
    padding-right: 130px;
    padding-top: 10px;
    padding-bottom: 10px;
    height: 70px;
    background-color: white;
    z-index: 10;
    width: 100%;
    box-sizing: border-box;
    /* Include padding in width */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Navbar Logo */
#navbar-logo img {
    display: block;
    width: auto;
    height: 40px;
}

/* Navbar Links */
#navbar-links {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-direction: row;
    flex-wrap: wrap;
    /* Allow wrapping */
}

/*Padding for Navbar Links */
#navbar-links ul {
    display: flex;
    list-style-type: none;
    padding: 0;
    margin: 0;
    gap: 15px;
    flex-wrap: wrap;
    /* Allow items to wrap */
}

#navbar-links a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding: 5px 10px;
    transition: color 0.3s ease;
}

#navbar-links a:hover {
    color: rgb(8, 132, 103);
}

/* Hamburger Menu */
.hamburger {
    display: none;
    cursor: pointer;
    font-size: 24px;
    user-select: none;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.container {
    top: 5px;
    position: relative;
    align-items: center;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    width: 15px;
    padding-right: 55px;
    padding-left: 0px;
}

.dropdown {
    position: absolute;
    top: 110%;
    left: -35px;
    width: 150px;
    background: white;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    z-index: 10;
    margin-left: 60px;
}

/* Mobile Styles */
@media (max-width: 768px) {
    #navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        padding: 10px 20px;
        height: 70px;
        background-color: white;
        z-index: 10;
        width: 100%;
        box-sizing: border-box;
        /* Include padding in width */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    #navbar-links {
        flex-direction: column;
        position: absolute;
        top: 70px;
        right: 0;
        background-color: white;
        border-radius: 5px;
        width: 100%;
        max-height: 0;
        overflow: hidden;
        height: 200px;
        transition: max-height 0.4s ease-in-out;
    }

    #navbar-links ul {
        flex-direction: column;
        gap: 0;
        padding: 10px 0;
        align-items: center;
    }

    #navbar-links ul li {
        padding: 10px 20px;
    }

    #navbar-links.show {
        max-height: 100vh;
    }

    .hamburger {
        display: block;
        font-size: 42px;
        padding-top: 20px;
        padding-bottom: 20px;
        cursor: pointer;
    }

    .container {
        left: 65px;
        top: 3px;
        position: relative;
        align-items: center;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        width: 15px;
    }

    .dropdown {
        position: absolute;
        top: 100%;
        left: -60px;
        width: 150px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        z-index: 10;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.4s ease, opacity 0.3s ease;
        margin-left: 60px;
    }

    /* Dropdown Active State */
    .dropdown.open {
        max-height: 400px;
        /* Adjust according to content */
        opacity: 1;
    }

    .dropdown-list {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 130px;
        text-align: center;

    }

    .dropdown-item {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
        transition: background 0.3s, transform 0.2s;
        cursor: pointer;
    }

    .cart-sidebar {
        width: 400px;
        /* Sidebar takes full width on mobile */
        right: -100%;
        /* Initially off-screen */
        height: 100%;
        /* Take full height on mobile */
    }

    #cart-sidebar.active {
        right: 0;
        /* Show the sidebar on mobile */
    }

    /* Cart content */
    .cart-header {
        padding: 10px;
        font-size: 18px;
    }

    .cart-footer {
        padding: 15px;
    }

    .checkout-btn {
        font-size: 18px;
    }

    div#cartSidebar {
        width: 400px;
        overflow-y: auto;
    }

    .cart-header {
        padding: 10px;
        font-size: 12px;
    }

    .cart-content {
        width: 100% !important;
        left: 0;
        right: 0;
        display: flex;
        flex-direction: column;
    }
}

.mycart-button p {
    display: flex;
}

.mycart-button {
    display: inline-flex;
    background: none;
    align-items: center;
    border: none;
    flex-direction: row-reverse;
    cursor: pointer;
    font-size: 20px;
    color: #333;
    padding: 10px;
    transition: color 0.3s;
}

.mycart-button:hover {
    color: rgb(8, 132, 103);
}

.cart-count {
    margin-top: -10px;
    font-size: 0.5em;
    /* Adjust size as needed */
    background-color: red;
    /* Background color for count */
    color: white;
    /* Text color for count */
    border-radius: 50%;
    /* Make it circular */
    padding: 2px 6px;
    /* Padding for better visibility */
    margin-left: 5px;
    /* Space between icon and count */
}

.dropdown-button {
    display: inline-flex;
    align-items: center;
    padding-right: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 0px;
    background: white;
    border-radius: 5px;
    cursor: pointer;
    border: white;
    transition: background 0.3s;
    font-size: 20px;
    color: #333;
}

.dropdown-button:hover {
    color: rgb(8, 132, 103);
}

.hidden {
    display: none;
}

.dropdown-list {
    list-style: none;
    padding: 0;
    width: 120px;
    text-align: center;
    align-items: center;
}

.dropdown-item {
    width: 100%;
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    transition: background 0.3s, transform 0.2s;
}

.dropdown-item:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
}

.dropdown-footer {
    padding: 10px;
    border-top: 1px solid #ccc;
}

/* Cart Sidebar Styles */
.cart-sidebar {
    position: fixed;
    top: 0;
    right: -600px;
    width: 600px;
    height: 80%;
    background-color: white;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
    transition: right 0.3s ease-in-out;
    z-index: 3000;
    display: flex;
    pointer-events: none;
    overflow-y: auto;
    flex-direction: column;
}

.cart-sidebar.active {
    right: 0;
    pointer-events: auto;
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #f0f0f0;
    border-bottom: 1px solid #ccc;
}

.cart-content {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    overflow: auto;
}

.cart-footer {
    padding: 15px;
    border-top: 1px solid #ccc;
    background-color: #f0f0f0;
}

.checkout-btn {
    width: 100%;
    padding: 10px;
    background-color: rgb(8, 132, 103);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.checkout-btn:hover {
    background-color: rgb(6, 100, 80);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('userDropdownButton1');
    const dropdown = document.getElementById('userDropdown1');

    dropdownButton.addEventListener('click', function() {
        dropdown.classList.toggle('hidden');
    });

    // Optional: Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdownButton.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const navbarLinks = document.getElementById('navbar-links');

    hamburger.addEventListener('click', () => {
        navbarLinks.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        if (!navbarLinks.contains(event.target) && !hamburger.contains(event.target)) {
            navbarLinks.classList.remove('show');
        }
    });
    // Toggle hamburger icon
    if (hamburger) {
        hamburger.onclick = () => {
            if (hamburger.textContent === '⚞') {
                hamburger.textContent = '☰';
            } else {
                hamburger.textContent = '⚞';
            }
        };
    };
});

const dropdownButton = document.querySelector('.dropdown-button');
const dropdown = document.querySelector('.dropdown');

dropdownButton.addEventListener('click', () => {
    dropdown.classList.toggle('open');
});

function toggleCart() {
    var cart = document.getElementById("cartSidebar");
    cart.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", function() {
    const cartButton = document.getElementById("mycart");
    const cartSidebar = document.getElementById("cartSidebar");
    const closeCart = document.querySelector(".close-btn");
    const cartContent = document.querySelector(".cart-content");

    //show the cart sidebar when clicking the cart button
    cartButton.addEventListener("click", function() {
        cartSidebar.classList.add("active");
        fetchCartItems(); //Fetch updated cart items
    });
    //close the cart sidebar when clicking the close button
    closeCart.addEventListener("click", function() {
        cartSidebar.classList.remove("active");
    });
    //close the cart sidebar when clicking outside the sidebar
    document.addEventListener("click", function(event) {
        if (!cartSidebar.contains(event.target) && !cartButton.contains(event.target)) {
            cartSidebar.classList.remove("active");
        }
    })
    //Fetch cart items from the server
    function fetchCartItems() {
        fetch("cart.php") // Changed to cart.php
            .then(response => response.text())
            .then(data => {
                document.querySelector(".cart-content").innerHTML = data;
            })
            .catch(error => console.error(error));
    }
    // Add event listener to the cart content form
    if (cartContent) {
        cartContent.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = event.target;
            const item_id = form.querySelector('input[name="item_id"]').value;
            const action = event.submitter?.value; // Get the value of the clicked button

            // Make an AJAX request to update the cart
            fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        item_id: item_id,
                        action: action,
                    })
                })
                .then(response => response.text())
                .then(data => {
                    cartContent.innerHTML = data; // Update the cart content
                })
                .catch(error => console.error(error));
        });
    }

});
</script>