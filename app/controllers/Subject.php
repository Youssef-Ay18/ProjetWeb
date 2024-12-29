<?php
include_once "db.php";
class Subject
{
    private $conn;

    public function __construct()
    {
        $this->conn = config::getConnexion();
    }

public function fetchById($id)
{
    $sql = "SELECT * FROM subject WHERE subject_ID = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

public function create($title, $content, $user_ID, $id_category)
{
    try {
        $stmt = $this->conn->prepare("
            INSERT INTO subject (title, content, user_ID, id_category, creation_date) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $creation_date = date('Y-m-d H:i:s');
        $stmt->bindValue(1, $title, PDO::PARAM_STR);
        $stmt->bindValue(2, $content, PDO::PARAM_STR);
        $stmt->bindValue(3, $user_ID, PDO::PARAM_INT);
        $stmt->bindValue(4, $id_category, PDO::PARAM_INT);
        $stmt->bindValue(5, $creation_date, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error in create(): " . $e->getMessage());
        return false;
    }
}


public function displayAll()
{
    try {
        $stmt = $this->conn->prepare('SELECT * FROM subject ');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
    public function displayAll1()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM subject where id_category = 1');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function displayAll2()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM subject where id_category = 2');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function displayAll3()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM subject where id_category = 3');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

 
 public function update($id, $title, $content, $user_ID , $id_category)
 {
     try {
         $stmt = $this->conn->prepare("UPDATE subject
                                       SET title = ?, content = ?, user_ID = ?, id_category = ?, creation_date = ? 
                                       WHERE subject_ID = ?");
 
         $updated_at = date('Y-m-d H:i:s');
         $stmt->bindValue(1, $title, PDO::PARAM_STR);
         $stmt->bindValue(2, $content, PDO::PARAM_STR);
         $stmt->bindValue(3, $user_ID, PDO::PARAM_INT);
         $stmt->bindValue(4, $id_category, PDO::PARAM_INT);
         $stmt->bindValue(5, $updated_at, PDO::PARAM_STR);
         $stmt->bindValue(6, $id, PDO::PARAM_INT);

         return $stmt->execute();
     } catch (PDOException $e) {
         error_log("Error in update(): " . $e->getMessage());
         return false;
     }
 }
 

public function getConnection()
{
    return $this->conn;
}

    


    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM subject WHERE subject_ID = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    
}
    if ($_SERVER['REQUEST_METHOD'] ==='POST'&& isset($_POST['update_question'])) {
        $id = $_POST['subject_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_ID = $_POST['user_id'];
        $id_category =$_POST['category_id'];
        $s = new Subject();
    
        if ($s-> update($id, $title, $content, $user_ID,$id_category)) {
            echo "<p>Question updated jawou behi</p>";
            header("Location: ../views/front_office/forum.php");
            exit;
        } else {
            echo "<p>There was an error updating the question.</p>";
        }
    }
    




?>
