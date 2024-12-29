<?php
session_start();  
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  
    exit;
}
include "../../controllers/Subject.php"; 
include "../../controllers/Answer.php"; 
$current_user_ID = $_SESSION['user_id'];

$question = new Subject(config::getConnexion());
$answer = new Answer();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_question'])) {
    $id = $_POST['question_id'];
    $questionData = $question->fetchById($id);
    if ($questionData && $questionData['user_ID'] == $current_user_ID) {
        $question->delete($id);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_question'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = 2;
    if ($question->create($title, $content, $current_user_ID,2)) {
        header("Location: forum2.php");
        exit;
    } else {
        echo "<p>Error: Could not create the question.</p>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_answer'])) {
    $answer_description = $_POST['answer_description'];
    $question_id = $_POST['question_id']; 
    if ($answer->create($question_id, $answer_description, $current_user_ID)) {
        header("Location: forum2.php"); 
        exit;
    } else {
        echo "Error occurred while creating the answer.";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_answer'])) {
    $answer_id = $_POST['answer_id'];
    $answerData = $answer->fetchById($answer_id);

    if ($answerData) {
        if ($answerData['user_ID'] == $current_user_ID) {
            $answer->delete($answer_id);
        } else {
            echo "<p>You do not have permission to delete this answer.</p>";
        }
    } else {
        echo "<p>Answer not found.</p>";
    }
}


$questions = $question->displayAll2();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ChefToBe/public/css/style.css">
    <title>Forum</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Forum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="forum1.php">Political</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forum2.php">Art</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forum3.php">Tech</a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= htmlspecialchars($_SESSION['user_name']); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1>Forum Subject</h1>
    <div class="questions">
        <?php foreach ($questions as $q) : ?>
            <div class="question border p-3 mb-3">
                <h3><?= htmlspecialchars($q['title']); ?></h3>
                <p><?= htmlspecialchars($q['content']); ?></p>
                <div class="buttons">
                    <?php if ($q['user_ID'] == $current_user_ID) : ?>
                        <a href="update.php?id=<?= intval($q['subject_ID']); ?>" class="btn btn-warning btn-sm">Update</a>
                        <form method="POST" action="" class="d-inline-block">
                            <input type="hidden" name="question_id" value="<?= intval($q['subject_ID']); ?>">
                            <button type="submit" name="delete_question" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="add-answer mt-3">
                    <h4>Answer this question:</h4>
                    <form method="POST" action="">
                        <textarea name="answer_description" class="form-control mb-2" placeholder="Your answer..." rows="3" required></textarea>
                        <input type="hidden" name="question_id" value="<?= intval($q['subject_ID']); ?>">
                        <button type="submit" name="create_answer" class="btn btn-primary">Add Answer</button>
                    </form>
                </div>
                <div class="answers mt-4">
                    <h4>Answers:</h4>
                    <?php
                    $answers = $answer->displayByQuestion($q['subject_ID']);
                    if (!empty($answers)) :
                        foreach ($answers as $ans) : ?>
                            <div class="answer border p-2 mb-2">
                                <p><?= htmlspecialchars($ans['answer_description']); ?></p>
                                <small class="text-muted">Created: <?= $ans['creation_date']; ?> | Updated: <?= $ans['update_date']; ?></small>
                                <div class="answer-buttons mt-2">
                                    <?php if ($ans['user_ID'] == $current_user_ID) : ?>
                                        <a href="updatea.php?id=<?= intval($ans['answer_ID']); ?>" class="btn btn-warning btn-sm">Update</a>
                                        <form method="POST" action="" class="d-inline-block">
                                            <input type="hidden" name="answer_id" value="<?= intval($ans['answer_ID']); ?>">
                                            <button type="submit" name="delete_answer" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No answers yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Create New Subject</h2>
    <form method="POST" action="" class="mt-3">
        <div class="mb-3">
            <input type="text" name="title" class="form-control" placeholder="Title" required>
        </div>
        <div class="mb-3">
            <textarea name="content" class="form-control" placeholder="Content" rows="2" required></textarea>
        </div>
        <button type="submit" name="create_question" class="btn btn-success">Create</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

