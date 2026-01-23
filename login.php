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
<div class="auth-container">
    <h2><i class="fas fa-lock" style="color: var(--primary-color);"></i> Sign In</h2>
    <?php if($message): ?>
        <div class="alert" style="background: #fee2e2; color: #991b1b; margin-bottom: 1rem; padding: 0.75rem;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login to Dashboard</button>
    </form>
    <p style="margin-top: 1.5rem; font-size: 0.875rem; color: var(--text-muted);">
        Don't have an account? <a href="register.php">Register now</a>
    </p>
</div>
<?php include 'templates/footer.php'; ?>
