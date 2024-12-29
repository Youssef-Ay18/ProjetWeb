<?php
include "../../controllers/Subject.php"; 
session_start();  
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  
    exit;
}
$subject_id=$_GET['id']; 
$subject =new Subject(config::getConnexion());
try {
    $conn=$subject->getConnection();
    $stmt= $conn->prepare("SELECT * FROM subject WHERE subject_ID = :id");
    $stmt->bindParam(':id', $subject_id, PDO::PARAM_INT);
    $stmt->execute();
    $q = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "error";
    $q = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Subject</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="card shadow-sm mt-5">
                <div class="card-header bg-success text-white text-center">
                    <h3>Update Subject</h3>
                </div>
                <div class="card-body">
                    <form action="../../controllers/Subject.php" method="POST">
                        <input type="hidden" name="subject_id" value="<?= htmlspecialchars($q['subject_ID']); ?>"> 
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($q['user_ID']); ?>"> 
                        <input type="hidden" name="category_id" value="<?= htmlspecialchars($q['id_category']); ?>">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($q['title']); ?>" class="form-control" placeholder="Enter new title" required> 
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Description</label>
                            <textarea id="content" name="content" class="form-control" placeholder="Enter new content" rows="4" required><?= htmlspecialchars($q['content']); ?></textarea>
                        </div>
                        
                        <button type="submit" name="update_question" class="btn btn-success w-100">Update Subject</button>
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
