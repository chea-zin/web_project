<?php
session_start();
require 'connections/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data (name and password) from the POST request
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Prepare an SQL statement to select the user by name
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    //fetch user from database
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the user exists and verify the entered password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['name'] = $user['name'];
        header("Location: profile.php");
        exit();
    } else {
        echo "Invalid name or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }
    form {
        width: 30%;
        margin: 0 auto;
        background: white;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        box-sizing: border-box;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #4a90e2;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    button:hover {
        background-color: #357ae8;
    }
    p {
        text-align: center;
    }
    a {
        color: #4a90e2;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <input type="text" name="name" placeholder="Enter your name" required><br><br>
        <input type="password" name="password" placeholder="Enter your password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
