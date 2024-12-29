<?php
include "../../controllers/Answer.php"; 
$answer = new Answer();
if (isset($_GET['answer_ID'])) {
    $answer_ID = intval($_GET['answer_ID']);
    $answerDetails = $answer->fetchById($answer_ID);
    if (!$answerDetails) {
        header("Location: back.php");
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer_description'])) {
    $updatedDescription = $_POST['answer_description'];
    if ($answer->update($answer_ID, $updatedDescription)) 
    {
        header("Location: back.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Answer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Answer</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="answer_description" class="form-label">Answer Description</label>
                <textarea id="answer_description" name="answer_description" class="form-control" rows="4" required><?php echo htmlspecialchars($answerDetails['answer_description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Answer</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
