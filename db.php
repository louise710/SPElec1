<?php
$host = '127.0.0.1';     
$dbname = 'usjr'; 
$username = 'root';      
$password = 'root';          

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";


try {
    $db = new PDO($dsn, $username, $password);
    // var_dump($db);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; 
}
?>