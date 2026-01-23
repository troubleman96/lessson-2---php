<?php
// CRUD page for textbooks
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'config/database.php';

$message = '';
$edit_mode = false;
$book_to_edit = null;

// Handle Delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM textbooks WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $message = "Book removed successfully!";
}

// Handle Add/Update
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    
    if(isset($_POST['id']) && !empty($_POST['id'])){
        // Update
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE textbooks SET title=:t, author=:a WHERE id=:id");
        $stmt->execute([':t'=>$title, ':a'=>$author, ':id'=>$id]);
        $message = "Book updated successfully!";
    } else {
        // Add
        $stmt = $pdo->prepare("INSERT INTO textbooks (title, author) VALUES (:t, :a)");
        $stmt->execute([':t'=>$title, ':a'=>$author]);
        $message = "Book added to collection!";
    }
}

// Handle Edit Request
if(isset($_GET['edit'])){
    $edit_mode = true;
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM textbooks WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $book_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle Search
$search = isset($_GET['q']) ? $_GET['q'] : '';
$query = "SELECT * FROM textbooks";
if($search){
    $query .= " WHERE title LIKE :q OR author LIKE :q";
}
$query .= " ORDER BY id DESC";

$stmt = $pdo->prepare($query);
if($search){
    $stmt->execute([':q' => "%$search%"]);
} else {
    $stmt->execute();
}
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include 'templates/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2><i class="fas fa-book-open"></i> Library Bookshelf</h2>
        <small style="color: var(--text-muted)"><?php echo count($books); ?> books found</small>
    </div>

    <?php if($message): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Search Box -->
    <form method="GET" class="search-box" style="display: block; background: none; padding: 0;">
        <i class="fas fa-search"></i>
        <input type="text" name="q" placeholder="Search by title or author..." value="<?php echo htmlspecialchars($search); ?>">
    </form>

    <!-- Add/Edit Form -->
    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem;">
        <h3 style="font-size: 1rem; margin-bottom: 1rem;">
            <i class="fas <?php echo $edit_mode ? 'fa-edit' : 'fa-plus'; ?>"></i> 
            <?php echo $edit_mode ? 'Edit Book' : 'Add New Book'; ?>
        </h3>
        <form method="POST" style="margin-bottom: 0;">
            <?php if($edit_mode): ?>
                <input type="hidden" name="id" value="<?php echo $book_to_edit['id']; ?>">
            <?php endif; ?>
            <input type="text" name="title" placeholder="Book Title" required value="<?php echo $edit_mode ? htmlspecialchars($book_to_edit['title']) : ''; ?>">
            <input type="text" name="author" placeholder="Author Name" required value="<?php echo $edit_mode ? htmlspecialchars($book_to_edit['author']) : ''; ?>">
            <button type="submit" name="submit">
                <?php echo $edit_mode ? 'Save Changes' : 'Add Book'; ?>
            </button>
            <?php if($edit_mode): ?>
                <a href="textbooks.php" style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.875rem;">Cancel</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Books Table -->
    <table>
        <thead>
            <tr>
                <th>Book Details</th>
                <th>Author</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($books)): ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                        <i class="fas fa-search" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                        No books found matching your criteria.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($books as $book): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($book['title']); ?></div>
                            <small style="color: var(--text-muted)">ID: #<?php echo $book['id']; ?></small>
                        </td>
                        <td>
                            <i class="fas fa-user-edit" style="color: var(--primary-color); font-size: 0.8rem; margin-right: 0.5rem;"></i>
                            <?php echo htmlspecialchars($book['author']); ?>
                        </td>
                        <td style="text-align: right;">
                            <a href="?edit=<?php echo $book['id']; ?>&q=<?php echo urlencode($search); ?>" class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <a href="?delete=<?php echo $book['id']; ?>&q=<?php echo urlencode($search); ?>" class="btn-icon btn-delete" title="Delete" onclick="return confirm('Are you sure you want to remove this book?')">
                                <i class="fas fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'templates/footer.php'; ?>
