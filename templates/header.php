<?php
// Header template for CamelLibrary
// Shows navigation and starts session if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CamelLibrary</title>
    <!-- Link to CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>CamelLibrary</h1>
    <?php if(isset($_SESSION['username'])): ?>
        <!-- Show menu if logged in -->
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> |
        <a href="home.php">Home</a> |
        <a href="textbooks.php">Textbooks</a> |
        <a href="logout.php">Logout</a></p>
    <?php else: ?>
        <!-- Show login/register if not logged in -->
        <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
    <?php endif; ?>
</header>
<div class="container">
