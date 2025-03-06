<?php
include_once "includes/connection.php";
class Category
{
    private $pdo;

    public function __construct(Connection $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function insert($cat_name): bool
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO category (cat_name) VALUES (:cat_name)");
            $stmt->bindParam(':cat_name', $cat_name);

            if ($stmt->execute()) {
                echo "Category Inserted Successfully!";
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
                throw new Exception(message: "Category ID is required for update.");
            }

            // Construct SET part of SQL
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ", "); // Remove last comma

            $sql = "UPDATE category SET $set WHERE cat_id = :cat_id";
            $stmt = $this->pdo->prepare($sql);

            // Bind values for SET
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            // Bind ID
            $stmt->bindValue(":cat_id", $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo $sql . "<br/>" . $e->getMessage();
        }
    }

    public function delete($id){
        try {
            $stmt = $this->pdo->prepare("DELETE FROM category WHERE cat_id = :cat_id");
            $stmt->bindParam(':cat_id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }
}

$db = new Connection();
$cat = new Category($db);
