<?php
include_once 'db.php';

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); 
        window.location.href='login.php';</script>";
        exit;
    }

    $sql = "SELECT * FROM appusers WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $username; 

        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Invalid username or password.'); 
        window.location.href='login.php';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
        <input type="reset" value="Clear">
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
