<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

// Assuming you have a function to fetch user details from the database
require 'connections/db.php';

$stmt = $pdo->prepare("SELECT email FROM users WHERE name = :name");
$stmt->bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/styles/profile.css" rel="stylesheet">
    <title>Profile</title>
</head>
<body>
    
    <?php include("components/nav.php"); ?>

    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        
        <div class="profile-actions">
            <a href="edit_profile.php" class="button">Edit Profile</a>
            <a href="order_history.php" class="button">Order History</a>
        </div>

        <h3>Your Order History</h3>
        <p>Here you can view your recent orders.</p>
        <ul class="order-history">
            <li>No orders yet.</li> 
        </ul>

        <a href="logout.php" class="logout-button">Logout</a>
    </div>

</body>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        padding-top: 0px; /* Add padding to avoid margin collapse */
    }

    .profile-container {
        max-width: 600px;
        margin: 200px auto; /* Center the container */
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
    }

    .profile-actions {
        margin: 20px 0;
    }

    .button {
        display: inline-block;
        padding: 10px 15px;
        margin-right: 10px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .logout-button {
        display: inline-block;
        padding: 10px 15px;
        background-color: #dc3545;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px; /* Add some space from the order history */
    }

    .logout-button:hover {
        background-color: #c82333;
    }

    .order-history {
        list-style-type: none;
        padding: 0;
        margin-top: 10px; /* Space above the order history */
    }

    .order-history li {
        padding: 5px 0;
    }
</style>
</html>