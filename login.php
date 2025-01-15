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
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            background-image: url("assets/img.png"); 
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
        <h2>Login</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] == '1'): ?>
                <p style="color: red;">Invalid username or password.</p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required autocomplete="off">
                </div>
                <button type="submit">Login</button>
            </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </body>
</html>
