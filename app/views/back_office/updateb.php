<?php

include "../../controllers/Subject.php";
$subjectObj = new Subject(config::getConnexion());
if (!isset($_GET['subject_ID']) || empty($_GET['subject_ID'])) {
    die("id ghalet");
}
$subject_ID = intval($_GET['subject_ID']);
$subject = $subjectObj->fetchById($subject_ID);
if (!$subject) 
{
    die("no famech");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $user_ID = $_POST['user_id'] ?? '';
    $id_category = $_POST['category_id'] ?? '';
    if (!empty($title) && !empty($content)) {
        $updateSuccess = $subjectObj->update($subject_ID, $title, $content, $user_ID , $id_category);
        if ($updateSuccess) {
            header("Location: back.php");
            exit;
        } else {
            $error = "failed";
        }
    } else {
        $error = "dekhel kol";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Update Question</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($subject['user_ID']); ?>"> 
        <input type="hidden" name="category_id" value="<?= htmlspecialchars($subject['id_category']); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($subject['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Description</label>
                <textarea name="content" id="content" class="form-control" rows="4" required><?= htmlspecialchars($subject['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Question</button>
            
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
