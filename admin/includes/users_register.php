<?php 
    include_once "includes/connection.php";
    class UserRegister{
        private $pdo;

        public function __construct(Connection $db){
            $this->pdo = $db->getConnection();
        }

        public function register($name, $email, $password){
            try{
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $this->pdo->prepare("INSERT INTO users_register (name, email, password) VALUES (:name, :email, :password)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                return $stmt->execute();
            }catch(PDOException $e){
                die("Error: ". $e->getMessage());
            }
        }
    }

    $db = new Connection();
    $user = new UserRegister($db);
?>