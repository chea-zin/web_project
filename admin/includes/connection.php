<?php
class Connection
{
    private $host = "localhost";
    private $dbname = "ecommerce_db";
    private $username = "root";
    private $password = "";
    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    // public function insert($table, $data)
    // {
    //     try {
    //         $columns = implode(",", array_keys($data));
    //         $values = ":" . implode(", :", array_keys($data));
    //         $sql = "INSERT INTO $table ($columns) values ($values)";
    //         $stmt = $this->pdo->prepare($sql);

    //         foreach ($data as $key => $value) {
    //             $stmt->bindValue(":$key", $value);
    //         }

    //         return $stmt->execute();
    //     } catch (PDOException $e) {
    //         echo $sql . "<br>" . $e->getMessage();
    //         return false;
    //     }
    // }

    // public function update($table, $data, $where)
    // {
    //     try {
    //         $set = "";
    //         foreach ($data as $key => $value) {
    //             $set .= "$key = :$key, ";
    //         }
    //         $set = rtrim($set, ", ");

    //         $condi = "";
    //         foreach ($where as $key => $value) {
    //             $condi .= "$key = :where_$key AND ";
    //         }
    //         $condi = rtrim($condi, " AND ");

    //         $sql = "UPDATE $table SET $set WHERE $condi";
    //         $stmt = $this->pdo->prepare($sql);

    //         foreach ($data as $key => $value) {
    //             $stmt->bindValue(":$key", $value);
    //         }
    //         foreach ($where as $key => $value) {
    //             $stmt->bindValue(":where_$key", $value);
    //         }
    //         return $stmt->execute();
    //     } catch (PDOException $e) {
    //         echo $sql . "<br>" . $e->getMessage();
    //     }
    // }

    // public function delete($table, $where)
    // {
    //     try {
    //         $condi = "";
    //         foreach ($where as $key => $value) {
    //             $condi .= "$key = :$key AND ";
    //         }
    //         $condi = rtrim($condi, " AND ");

    //         $sql = "DELETE FROM $table WHERE $condi";
    //         $stmt = $this->pdo->prepare($sql);

    //         foreach ($where as $key => &$value) {
    //             $stmt->bindParam(":$key", $value);
    //         }

    //         return $stmt->execute();
    //     } catch (Exception $e) {
    //         echo "Connection failed: " . $e->getMessage();
    //     }
    // }

    // public function select($table, $columns = "*", $where = [])
    // {
    //     try {
    //         $sql = "SELECT $columns FROM $table";

    //         if (!empty($where)) {
    //             $condi = "";

    //             foreach ($where as $key => $value) {
    //                 $condi .= "$key = :$key AND ";
    //             }

    //             $condi = rtrim($condi, " AND ");
    //             $sql .= " WHERE $condi";
    //         }

    //         $stmt = $this->pdo->prepare($sql);

    //         foreach ($where as $key => &$value) {
    //             $stmt->bindParam(":$key", $value);
    //         }
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (Exception $e) {
    //         echo "Connection failed: " . $e->getMessage();
    //     }
    // } 
}



