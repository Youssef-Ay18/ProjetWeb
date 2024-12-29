<?php
include_once "db.php";
class Answer
{
    private $conn;

    public function __construct()
    {
        $this->conn = config::getConnexion();
    }
    public function fetchById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM answer WHERE answer_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function create($question_ID, $answer_description, $user_ID)
    {
        try {
            $creation_date = date('Y-m-d H:i:s');
            $update_date = $creation_date;

            $stmt = $this->conn->prepare("
                INSERT INTO answer (question_ID, answer_description, user_ID, creation_date, update_date) 
                VALUES (:question_ID, :answer_description, :user_ID, :creation_date, :update_date)
            ");

            $stmt->bindParam(':question_ID', $question_ID, PDO::PARAM_INT);
            $stmt->bindParam(':answer_description', $answer_description, PDO::PARAM_STR);
            $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);  // Bind user_ID
            $stmt->bindParam(':creation_date', $creation_date);
            $stmt->bindParam(':update_date', $update_date);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function displayByQuestion($question_ID)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT * FROM answer WHERE question_ID = :question_ID ORDER BY creation_date ASC
            ");

            $stmt->bindParam(':question_ID', $question_ID, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public function update($answer_ID, $answer_description)
    {
        try {
            $update_date = date('Y-m-d H:i:s');

            $stmt = $this->conn->prepare("
                UPDATE answer SET answer_description = :answer_description, update_date = :update_date WHERE answer_ID = :answer_ID
            ");
            $stmt->bindParam(':answer_description', $answer_description, PDO::PARAM_STR);
            $stmt->bindParam(':update_date', $update_date);
            $stmt->bindParam(':answer_ID', $answer_ID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function delete($answer_ID)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM answer WHERE answer_ID = :answer_ID");

            $stmt->bindParam(':answer_ID', $answer_ID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function displayAllAnswers() 
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM answer ORDER BY answer_ID DESC');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return []; 
        }
    }
    
}
?>
