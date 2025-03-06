
=======
<?php
include_once "includes/connection.php";
class User
{
    private $pdo;

    public function __construct(Connection $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function insert($name, $email, $password): bool
    {
        try {
            $hashedPassword = password_hash(password: $password, algo: PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name,:email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                echo "User Inserted Successfully!";
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
                throw new Exception("User ID is required for update.");
            }

            // Construct SET part of SQL
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ", "); // Remove last comma

            $sql = "UPDATE users SET $set WHERE id = :id";
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
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }
}

$db = new Connection();
$user = new User($db);
>>>>>>> mony
