<?php
// SQLite database file path
$db_file = __DIR__ . '/../camellibrary.sqlite';
// If running from lesson2 folder, adjust path if needed
if (!file_exists($db_file)) {
    $db_file = __DIR__ . '/../camellibrary.sqlite'; // fallback, but should exist now
}

try {
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT
    )");

    // Create textbooks table
    $pdo->exec("CREATE TABLE IF NOT EXISTS textbooks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        author TEXT
    )");

    // Seed textbooks if empty
    $count = $pdo->query("SELECT COUNT(*) FROM textbooks")->fetchColumn();
    if ($count == 0) {
        $books = [
            ['Think and Grow Rich', 'Napoleon Hill'],
            ['The Strangest Secret', 'Earl Nightingale'],
            ['The Richest Man in Babylon', 'George S. Clason'],
            ['How to Win Friends and Influence People', 'Dale Carnegie'],
            ['The Power of Positive Thinking', 'Norman Vincent Peale'],
            ['The 7 Habits of Highly Effective People', 'Stephen Covey'],
            ['Man\'s Search for Meaning', 'Viktor Frankl'],
            ['The Alchemist', 'Paulo Coelho'],
            ['Meditations', 'Marcus Aurelius'],
            ['As a Man Thinketh', 'James Allen']
        ];
        $stmt = $pdo->prepare("INSERT INTO textbooks (title, author) VALUES (?, ?)");
        foreach ($books as $book) {
            $stmt->execute($book);
        }
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
