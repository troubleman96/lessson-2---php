<?php
// Home page after login
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'templates/header.php';
?>
<h2>Home Page</h2>
<p>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>! Use the menu above to manage textbooks.</p>
<?php include 'templates/footer.php'; ?>
