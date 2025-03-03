<?php
session_start(); 
include("connections/db.php"); 

class Cart {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUserID() {
        if (isset($_SESSION['name'])) {
            try {
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE name = :name");
                $stmt->bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    return $user['id'];
                } else {
                    return null; // User not found
                }
            } catch (PDOException $e) {
                error_log("Error in getUserID: " . $e->getMessage());
                return null; // Database error
            }
        } else {
            return null; // User not logged in
        }
    }

    public function addToCart($user_id, $product_name, $product_price, $product_image) {
        try {
            // Check if the product is already in the user's cart
            $cartCheckStmt = $this->pdo->prepare("SELECT * FROM user_cart WHERE user_id = :user_id AND product_name = :product_name");
            $cartCheckStmt->execute([
                ':user_id' => $user_id,
                ':product_name' => $product_name
            ]);
            $cartItem = $cartCheckStmt->fetch(PDO::FETCH_ASSOC);

            if ($cartItem) {
                // If product already exists in the cart, update the quantity
                $updateCartStmt = $this->pdo->prepare("UPDATE user_cart SET quantity = quantity + 1 WHERE id = :id");
                $updateCartStmt->execute([
                    ':id' => $cartItem['id']
                ]);
            } else {
                // If product is not in the cart, insert a new cart item
                $insertCartStmt = $this->pdo->prepare("INSERT INTO user_cart (user_id, product_name, product_price, product_image, quantity) VALUES (:user_id, :product_name, :product_price, :product_image, 1)");
                $insertCartStmt->execute([
                    ':user_id' => $user_id,
                    ':product_name' => $product_name,
                    ':product_price' => $product_price,
                    ':product_image' => $product_image
                ]);
            }
            return true; // Success
        } catch (PDOException $e) {
            error_log("Error in addToCart: " . $e->getMessage());
            return false; // Failure
        }
    }
}
?>