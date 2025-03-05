document.querySelector('form').addEventListener('submit', function (e) {
    const password = document.querySelector('input[name="password"]').value;
    if (password.length < 6) {
        alert('Password must be at least 6 characters long.');
        e.preventDefault();
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const cartButton = document.getElementById("mycart");
    const cartSidebar = document.getElementById("cartSidebar");
    const closeCart = document.getElementById("closeCart");

    // Show the cart sidebar when clicking the cart button
    cartButton.addEventListener("click", function () {
        cartSidebar.classList.add("active");
        fetchCartItems(); // Fetch updated cart items
    });

    // Close the cart sidebar when clicking the close button
    closeCart.addEventListener("click", function () {
        cartSidebar.classList.remove("active");
    });

    // Close the cart sidebar when clicking outside of it
    document.addEventListener("click", function (event) {
        if (!cartSidebar.contains(event.target) && !cartButton.contains(event.target)) {
            cartSidebar.classList.remove("active");
        }
    });

    // Fetch cart items dynamically from the database
    function fetchCartItems() {
        fetch("fetch_cart.php") // This should return cart items as HTML or JSON
            .then(response => response.text())
            .then(data => {
                document.querySelector(".cart-content").innerHTML = data;
            })
            .catch(error => console.error("Error fetching cart:", error));
    }
});
