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

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
