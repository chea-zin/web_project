<?php
session_start();
include("connections/db.php");

// Fetch the logged-in user's ID
$stmt = $pdo->prepare("SELECT id FROM users WHERE name = :name");
$stmt->bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $user['id'];


// Update quantities and remove items
if (isset($_POST['action']) && isset($_POST['item_id'])) {  // CHECK FOR 'action' and 'item_id'
    $item_id = $_POST['item_id'];
    $action = $_POST['action'];  // Get the action (increase, decrease, remove)

    if ($action === 'increase') {
        $updateStmt = $pdo->prepare("UPDATE user_cart SET quantity = quantity + 1 WHERE id = :item_id");
        $updateStmt->execute([':item_id' => $item_id]);
    } elseif ($action === 'decrease') {
        $updateStmt = $pdo->prepare("UPDATE user_cart SET quantity = GREATEST(quantity - 1, 1) WHERE id = :item_id"); // Prevent negative quantities
        $updateStmt->execute([':item_id' => $item_id]);
    } elseif ($action === 'remove') {
        $deleteStmt = $pdo->prepare("DELETE FROM user_cart WHERE id = :item_id");
        $deleteStmt->execute([':item_id' => $item_id]);
    }
}

// Fetch the user's cart items from the database
$cartItemsStmt = $pdo->prepare("SELECT * FROM user_cart WHERE user_id = :user_id");
$cartItemsStmt->execute([':user_id' => $user_id]);
$cartItems = $cartItemsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* General Page Styling */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        color: #343a40;
        padding: 20px;
        line-height: 1.6;
    }

    h1 {
        margin-top:80px;
        text-align: center;
        color: #28a745;
        margin-bottom: 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .cart-container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        overflow: auto;
        overflow-y: auto;
        padding: 20px;
        margin-top: 10px;
        align-items: center;
        text-align: center;
    }

    .cart-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .product-info {
        display: flex;
        align-items: center;
    }

    .product-image {
        width: 75px;
        height: auto;
        border-radius: 0.3rem;
        box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.1);
        margin-right: 15px;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .product-price {
        color: #28a745;
        font-size: 1.1rem;
    }

    .quantity-actions {
        display: flex;
        align-items: center;
    }

    .quantity-button {
        background-color: transparent;
        border: 1px solid #28a745;
        color: #28a745;
        padding: 0.3rem 0.6rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .quantity-button:hover {
        background-color: #28a745;
        color: #fff;
    }

    .item-total {
        font-weight: 500;
    }

    .remove-button {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 0.3rem 0.6rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-button:hover {
        background-color: #c82333;
    }

    .cart-total {
        font-weight: bold;
        text-align: right;
        padding: 1rem;
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }

    .cart-total span {
        color: #28a745;
        font-size: 1.25rem;
    }

    .button {
        display: block;
        margin: 20px auto;
        padding: 0.75rem 1.5rem;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s ease;
        width: fit-content;
    }

    .button:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-info {
            margin-bottom: 15px;
        }

        .quantity-actions {
            margin-top: 15px;
        }

        .cart-total {
            text-align: left;
        }
        .cart-container {
            height: 90%;
            overflow-y: auto;
        }
    }
    </style>
</head>

<body>
    <?php include("components/nav.php"); ?>
    <h1>My Shopping Cart</h1>
    <div class="cart-container">
        <?php if ($cartItems): ?>
        <?php
            $total = 0;
            foreach ($cartItems as $item):
                $item_total = $item['product_price'] * $item['quantity'];
                $total += $item_total;
            ?>
            <div class="cart-item">
                <div class="product-info">
                    <img src="<?php echo htmlspecialchars($item['product_image']); ?>"
                         alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="product-image">
                    <div class="product-details">
                        <div class="product-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                        <div class="product-price">$<?php echo number_format($item['product_price'], 2); ?></div>
                    </div>
                </div>
                <div class="quantity-actions">
                    <form method="post" action="">
                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                        <button class="quantity-button" type="submit" name="action" value="decrease">-</button>
                        <?php echo $item['quantity']; ?>
                        <button class="quantity-button" type="submit" name="action" value="increase">+</button>
                        <button class="remove-button" type="submit" name="action" value="remove">Remove</button> <!-- All buttons inside ONE form -->
                    </form>
                </div>
                <div class="item-total">$<?php echo number_format($item_total, 2); ?></div>
            </div>
        <?php endforeach; ?>
        <div class="cart-total">Total: <span>$<?php echo number_format($total, 2); ?></span></div>
        <?php else: ?>
        <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>  
</body>
</html>