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
<div class="auth-container">
    <h2><i class="fas fa-user-plus" style="color: var(--primary-color);"></i> Join Library</h2>
    <?php if($message): ?>
        <div class="alert" style="background: #f0f9ff; color: #075985; margin-bottom: 1rem; padding: 0.75rem;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Create Account</button>
    </form>
    <p style="margin-top: 1.5rem; font-size: 0.875rem; color: var(--text-muted);">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>
<?php include 'templates/footer.php'; ?>
