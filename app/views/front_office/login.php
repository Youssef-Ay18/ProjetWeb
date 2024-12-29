<?php
session_start();
session_unset(); 
session_destroy(); 

session_start();
include "../../controllers/User.php"; 

$user = new User(config::getConnexion());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email =$_POST['email'];
    $password = trim($_POST['password']);
    $fetchedUser = $user->fetchByEmail($email);
    $pass=$fetchedUser['password'];
    $role=$fetchedUser['role'];

    
        if ($password==$pass) 
        {
            $_SESSION['user_id'] = $fetchedUser['id'];
            $_SESSION['user_name'] = $fetchedUser['name'];
            $_SESSION['user_email'] = $fetchedUser['email'];
            //session_regenerate_id(true); 
            if ($role != "admin")
            {
                header("Location: forum.php");
                exit;
            }
            else
            {
                header("Location: ../back_office/back.php");
                exit;
            }

        } 
        else 
        {
            var_dump($email);
            var_dump($password);
            echo "Invalid email or password";
        }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../../public/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="../../public/js/login.js" defer></script>
</head>
<body>

<div class="container">
    <header>Login</header>
    <form method="POST" action="" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <footer>
        Don't have an account? <a href="signup.php">Sign Up</a>
    </footer>
</div>

</body>
</html>
