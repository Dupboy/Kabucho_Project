<?php
$host = 'localhost'; // Your database host
$db = 'Kabucho'; // Your database name
$user = 'madmax'; // Your database user
$pass = '*Conex001*'; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Only display the error message if there's an issue
    die("Could not connect to the database $db: " . $e->getMessage());
}
?>
