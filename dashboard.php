<<<<<<< HEAD
<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    echo "<script>alert('You must log in first.');
    window.location.href='login.php';</script>";
    exit;
}

$username = $_SESSION['username']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>You are logged in as: <?php echo htmlspecialchars($username); ?>
    <button><a href="logout.php">Logout</a></button></h2>
    
    <button>Add new Student</button>
    <p>CRUD here //table</p>
</body>
</html>
=======
<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    echo "<script>alert('You must log in first.');
    window.location.href='login.php';</script>";
    exit;
}

$username = $_SESSION['username']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>You are logged in as: <?php echo htmlspecialchars($username); ?>
    <button><a href="logout.php">Logout</a></button></h2>
    
    <button>Add new Student</button>
    <p>CRUD here //table</p>
</body>
</html>
>>>>>>> 6b68f52ddbeb9ab58f368171fa249bb9cf0c1b84
