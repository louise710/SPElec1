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
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            background-image: url("img.png"); 
            background-repeat: no-repeat;
            background-size: cover; 
            background-position: center;
            font-family: 'Space Grotesk', sans-serif;
        }
        .login-container {
            width: 250px; 
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
            display: grid;
            justify-items: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 2px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #00ab60;
            color: #fff;
            border: none;
            border-radius: 100px;
            cursor: pointer;
            margin: 5px 0; 
            text-align: center;
            font-size: medium;
        }
        .reset{
            width: 100%;
            padding: 10px;
            background-color: #ff2c2c;
            color: #fff;
            border: none;
            border-radius: 100px;
            cursor: pointer;
            margin: 5px 0; 
            text-align: center;
            font-size: medium;
        }
        a {
            font-size: small;
            color: black;
            text-align: center;
            text-decoration: none; 
            margin-top: 10px;
        
        }
        p {
            font-size: small;
            color: black;
            text-align: center;
            text-decoration: none; 
            margin-top: 10px;
        }

        button:hover {
            background-color: #009b56;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Add New User</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Verify Password" required autocomplete="off">
            </div>
            <button type="submit" value="Register">Register</button>
            <button class = "reset" type="reset" value="Clear">Reset</button>
        </form>
    </div>
</body>
</html>
