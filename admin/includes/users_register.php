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
                $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                return $stmt->execute();
            }catch(PDOException $e){
                die("Error: ". $e->getMessage());
            }
        }

        public function login($name, $password){
            $sql = "SELECT name, password FROM users WHERE name = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(params: [$name]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user && password_verify($password, $user['password'])){
                return true;
            }
            return false;
        }
    }

    $db = new Connection();
    $user = new UserRegister($db);
?>