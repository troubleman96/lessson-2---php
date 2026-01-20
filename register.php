<?php
// Registration page for new users
include 'config/database.php';
$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username,password) VALUES (:u,:p)");
        $stmt->execute([':u'=>$username, ':p'=>$password]);
        $message = "User registered successfully. <a href='login.php'>Login now</a>";
    } catch(PDOException $e) {
        $message = "Error: Username may already exist!";
    }
}
?>
<?php include 'templates/header.php'; ?>
<h2>Register</h2>
<?php if($message) echo "<p>$message</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
<?php include 'templates/footer.php'; ?>
