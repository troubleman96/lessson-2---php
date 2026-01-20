<?php
// CRUD page for textbooks
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'config/database.php';
$message = '';
// Handle Add textbook
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $stmt = $pdo->prepare("INSERT INTO textbooks (title, author) VALUES (:t, :a)");
    $stmt->execute([':t'=>$title, ':a'=>$author]);
    $message = "Textbook added!";
}
// Handle Delete textbook
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM textbooks WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $message = "Textbook deleted!";
}
// Fetch all textbooks
$books = $pdo->query("SELECT * FROM textbooks")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'templates/header.php'; ?>
<h2>Textbooks</h2>
<?php if($message) echo "<p>$message</p>"; ?>
<h3>Add Textbook</h3>
<form method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <button type="submit" name="add">Add</button>
</form>
<h3>All Textbooks</h3>
<table>
    <tr><th>ID</th><th>Title</th><th>Author</th><th>Action</th></tr>
    <?php foreach($books as $book): ?>
        <tr>
            <td><?php echo $book['id']; ?></td>
            <td><?php echo htmlspecialchars($book['title']); ?></td>
            <td><?php echo htmlspecialchars($book['author']); ?></td>
            <td><a href="?delete=<?php echo $book['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include 'templates/footer.php'; ?>
