<?php
include_once "includes/connection.php";
class Products
{
    private $pdo;

    public function __construct(Connection $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function insert($name, $description, $price, $image): bool
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);

            if ($stmt->execute()) {
                echo "Product Inserted Successfully!";
                return true;
            } else {
                echo "Failed to Insert!";
                print_r($stmt->errorInfo());  // Debugging line
                return false;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {

        try {
            // Ensure ID is provided
            if (empty($id)) {
                throw new Exception(message: "Product ID is required for update.");
            }

            // Construct SET part of SQL
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ", "); // Remove last comma

            $sql = "UPDATE products SET $set WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            // Bind values for SET
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            // Bind ID
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo $sql . "<br/>" . $e->getMessage();
        }
    }

    public function delete($id){
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }
}

$db = new Connection();
$cat = new Products($db);
