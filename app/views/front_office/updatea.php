<?php
include "../../controllers/db.php";
include "../../controllers/Subject.php";
include "../../controllers/Answer.php";
session_start(); 
$current_user_ID =  $_SESSION['user_id'];; 


$subject = new Subject(config::getConnexion());
$answer = new Answer();
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $answer_id = $_GET['id']; 
    $answerData = $answer->fetchById($answer_id);
    if ($answerData) {
      
        if ($answerData['user_ID'] != $current_user_ID) 
        {
            echo "andekch lhek";
            exit;
        }
    } else {
        echo "famech";
        exit;
    }
} else 
{
    echo "id error";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_answer'])) {
    $updated_answer_description = $_POST['answer_description'];
    if ($answer->update($answer_id, $updated_answer_description)) {
        header("Location: forum.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Answer</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="card shadow-sm mt-5">
                <div class="card-header bg-success text-white text-center">
                    <h3>Update Your Answer</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="answer_description" class="form-label">Answer Description</label>
                            <textarea id="answer_description" name="answer_description" class="form-control" rows="5" required><?= htmlspecialchars($answerData['answer_description']); ?></textarea>
                        </div>
                        <button type="submit" name="update_answer" class="btn btn-success w-100">Update Answer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
