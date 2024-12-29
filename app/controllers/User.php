<?php
include_once "db.php";
class User
{
    private $conn;

        public function __construct()
        {
            $this->conn = config::getConnexion();
        }
        public function getConnection()
        {
        return $this->conn;
        }
        public function fetchByEmail($email) {
            $sql = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
    

        public function createUser($name, $email, $password, $role = 'user') 
{
    try {
        $stmt = $this->conn->prepare("
            INSERT INTO user (name, email, password, role) 
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bindValue(1, $name, PDO::PARAM_STR);  
        $stmt->bindValue(2, $email, PDO::PARAM_STR); 
        $stmt->bindValue(3, $password, PDO::PARAM_STR); 
        $stmt->bindValue(4, $role, PDO::PARAM_STR); 

        return $stmt->execute();
    } catch (PDOException $e) {
        
        error_log("Error in createUser(): " . $e->getMessage());
        return false;
    }
}
        public function displayAll1()
        {
            try {
                $stmt = $this->conn->prepare('SELECT * FROM user WHERE id_category = 1');
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
        public function displayAll2()
        {
            try {
                $stmt = $this->conn->prepare('SELECT * FROM user WHERE id_category = 2');
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
        public function displayAll3()
        {
            try {
                $stmt = $this->conn->prepare('SELECT * FROM user WHERE id_category = 3');
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }


        public function update($id, $name, $email, $password )
        {
            try {
                $stmt = $this->conn->prepare("UPDATE user SET name = ?,  email= ?, password= ? WHERE id = ?");
                $stmt->bindValue(1, $name, PDO::PARAM_STR);
                $stmt->bindValue(2, $email, PDO::PARAM_STR);
                $stmt->bindValue(3, $password, PDO::PARAM_STR);
                $stmt->bindValue(4, $id, PDO::PARAM_INT);
       
                return $stmt->execute();
            } catch (PDOException $e) {
                error_log("Error in update(): " . $e->getMessage());
                return false;
            }
        }
        public function delete($id)
        {
            $stmt = $this->conn->prepare("DELETE FROM user WHERE id = ?");
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
        public function getUserById($id) {
            try {
                $conn = $this->getConnection(); 
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }
        


        
    }

    

?>