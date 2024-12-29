<?php
session_start(); 
include "../../controllers/User.php";

$user = new User(config::getConnexion());

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) 
{

    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
        if ($user->createUser($name, $email, $password, $role = 'user') ) 
        {
            $createdUser = $user->fetchByEmail($email);
            $_SESSION['user_id'] = $createdUser['id'];
            $_SESSION['user_name'] = $createdUser['name'];
            $_SESSION['user_email'] = $createdUser['email'];
            //session_regenerate_id(true); 
            header("Location: forum.php");
            exit;
        }
        else {
            echo "<p>Error creating user</p>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../../../public/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="../../public/js/login.js" defer></script>
</head>
<body>

<div class="container">
    <header>Sign Up</header>
    <form method="POST" action="" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter a password" required>
        </div>
        <button name="create_user" type="submit">Sign Up</button>
    </form>
    <footer>
        Already have an account? <a href="login.php">Login</a>
    </footer>
</div>

</body>
</html>
