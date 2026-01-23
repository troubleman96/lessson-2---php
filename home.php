<?php
// Home page after login
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'templates/header.php';
?>
<div class="hero-section">
    <h2><i class="fas fa-hand-wave" style="color: #f59e0b;"></i> Welcome Home</h2>
    <p>Success starts with knowledge. Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>! You have full access to the library management system.</p>
    <a href="textbooks.php"><button style="width: auto;">Manage Textbooks <i class="fas fa-arrow-right"></i></button></a>
</div>
<?php include 'templates/footer.php'; ?>
