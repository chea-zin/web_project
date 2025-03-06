<?php
session_start();
include("connections/db.php");

// Fetch the logged-in user's ID
$stmt = $pdo->prepare("SELECT id FROM users WHERE name = :name");
$stmt->bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $user['id'];

// Fetch cart items
$cartStmt = $pdo->prepare("SELECT * FROM user_cart WHERE user_id = :user_id");
$cartStmt->execute([':user_id' => $user_id]);
$cartItems = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['product_price'] * $item['quantity'];
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $payment_method = $_POST['payment_method'];
    $orderStmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, payment_method, status) VALUES (:user_id, :total_price, :payment_method, 'Pending')");
    $orderStmt->execute([':user_id' => $user_id, ':total_price' => $total, ':payment_method' => $payment_method]);
    $order_id = $pdo->lastInsertId();
    
    foreach ($cartItems as $item) {
        $orderItemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity) VALUES (:order_id, :product_name, :product_price, :quantity)");
        $orderItemStmt->execute([
            ':order_id' => $order_id,
            ':product_name' => $item['product_name'],
            ':product_price' => $item['product_price'],
            ':quantity' => $item['quantity']
        ]);
    }
    
    $pdo->prepare("DELETE FROM user_cart WHERE user_id = :user_id")->execute([':user_id' => $user_id]);
    header("Location: order_success.php?order_id=$order_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="assets/styles/homepage/styles.css" rel="stylesheet">
    <style>

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            text-align: center;
        }

        .cart-container-c {
            max-width: 600px;
            margin: auto;
            margin-top: 55px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            flex-direction: column;
            display: flex;
            align-items: center;
            text-align: center;
        }

        h1 {
            color: #28a745;
            font-size: 24px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }

        p {
            font-size: 18px;
            font-weight: bold;
        }

        select, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 10px;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
    
</head>
<body>
    <?php include("components/nav.php"); ?>
    <div class="cart-container-c">
        <?php if ($cartItems): ?>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li><?php echo htmlspecialchars($item['product_name']) . " x " . $item['quantity'] . " - $" . number_format($item['product_price'] * $item['quantity'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>Total: $<?php echo number_format($total, 2); ?></p>
            <form method="post" action="">
                <label for="payment_method">Select Payment Method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                </select>
                <button type="submit" name="place_order">Place Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
