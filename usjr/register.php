<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "Please fill in all fields.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); 
        window.location.href='register.php';</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO appusers VALUES (NULL, ?, ?)";
    $insert = $db->prepare($sql);
    
    $insert->bindParam(1, $username, PDO::PARAM_STR);
    $insert->bindParam(2, $hashed_password, PDO::PARAM_STR);

    $result = $insert->execute();
    if($result) {
        echo "<script>alert('Registration successful for username: " . htmlspecialchars($username) . "');
        window.location.href='login.php';</script>";
    } else {
        echo "User was not added to the table.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Add New User</h2>
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="confirm_password">Verify Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        
        <input type="submit" value="Register">
        <input type="reset" value="Clear">
    </form>
</body>
</html>
