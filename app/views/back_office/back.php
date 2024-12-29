<?php
include "../../controllers/Subject.php";
include "../../controllers/Answer.php";
$subject = new Subject(config::getConnexion());
$answer = new Answer(config::getConnexion());
$subjects =$subject->displayAll();
$answers = $answer->displayAllAnswers();
if (isset($_GET['action']) && $_GET['action'] === 'delete_subject' && isset($_GET['subject_ID'])) {
    $subject_ID = intval($_GET['subject_ID']);
    if ($subject->delete($subject_ID)) {
        header("Location: back.php");
        exit;
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'delete_answer' && isset($_GET['answer_ID'])) {
    $answer_ID = intval($_GET['answer_ID']);
    if ($answer->delete($answer_ID)) {
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
    <title>Back Office - Questions & Answers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Manage Subjects and Answers</h2>
        <div class="mt-5">
            <h3>Existing Questions</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Question ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Asked By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($subjects) && !empty($subjects)): ?>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subject['subject_ID']); ?></td>
                                <td><?php echo htmlspecialchars($subject['title']); ?></td>
                                <td><?php echo htmlspecialchars($subject['content']); ?></td>
                                <td><?php echo htmlspecialchars($subject['id_category']); ?></td>
                                <td><?php echo htmlspecialchars($subject['creation_date']); ?></td>
                                <td><?php echo htmlspecialchars($subject['user_ID']); ?></td>
                                <td>
                                    <a href="updateb.php?action=edit_subject&subject_ID=<?php echo $subject['subject_ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="back.php?action=delete_subject&subject_ID=<?php echo $subject['subject_ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No questions available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <h3>Existing Answers</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Answer ID</th>
                        <th>Question ID</th>
                        <th>Answer Description</th>
                        <th>Answered By</th>
                        <th>Creation Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($answers) && !empty($answers)): ?>
                        <?php foreach ($answers as $answerItem): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($answerItem['answer_ID']); ?></td>
                                <td><?php echo htmlspecialchars($answerItem['question_ID']); ?></td>
                                <td><?php echo htmlspecialchars($answerItem['answer_description']); ?></td>
                                <td><?php echo htmlspecialchars($answerItem['user_ID']); ?></td>
                                <td><?php echo htmlspecialchars($answerItem['creation_date']); ?></td>
                                <td>
                                    <a href="updateba.php?action=edit_answer&answer_ID=<?php echo $answerItem['answer_ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="back.php?action=delete_answer&answer_ID=<?php echo $answerItem['answer_ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this answer?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No answers available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
