<?php
// Login page for users
include 'config/database.php';
session_start();
$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:u");
    $stmt->execute([':u'=>$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($password, $user['password'])){
        $_SESSION['username'] = $user['username'];
        header("Location: home.php");
        exit;
    } else {
        $message = "Invalid username or password";
    }
}
?>
<?php include 'templates/header.php'; ?>
<h2>Login</h2>
<?php if($message) echo "<p>$message</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<?php include 'templates/footer.php'; ?>
