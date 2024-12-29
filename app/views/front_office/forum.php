<?php
session_start();  
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  
    exit;
}
include "../../controllers/Subject.php"; 
include "../../controllers/Answer.php"; 
$current_user_ID = $_SESSION['user_id'];


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
    <br>
    <h1>Forum Subject</h1>
    <br>
    <br>
    <h3>Please Select category to Start Disscusion  :3</h3>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

