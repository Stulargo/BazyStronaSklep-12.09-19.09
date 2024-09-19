<?php
session_start();
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <div class="container">
        <form method="post" action="login_action.php">
            Login: <input type="text" name="login" required><br>
            Password: <input type="password" name="pass" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
