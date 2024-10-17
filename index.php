<?php include 'includes/header.html';  ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-image">
                <img src="img/1millon.png" alt="Logo"> 
            </div>
            <div class="login-form">
                <h2>Welcome!</h2>
                <form action="logic/login_logic.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                    <a href="#">Forgot Password?</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
