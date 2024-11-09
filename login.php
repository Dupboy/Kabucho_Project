<?php
session_start(); // Start the session
include 'config.php'; // Include the database configuration

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$loginMessage = ""; // Variable to store login messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['username'] = $user['username']; // Optionally store username
            header("Location: Dashboard.php"); // Redirect to the dashboard
            exit; // Ensure the script stops running after redirection
        } else {
            $loginMessage = "<p class='error'>Incorrect password.</p>";
        }
    } else {
        $loginMessage = "<p class='error'>No account found with that email.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container login">
        <h1>Login</h1>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <?php
        // Display the login message below the button
        echo $loginMessage;
        ?>
        <p>Don't have an account? <a href="signup.php">Signup here</a></p>
    </div>
</body>
</html>
