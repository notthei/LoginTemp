<?php
//初回時のみ実行しdbを作成する
require_once 'database.php';

$db = getDbConnection();

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT
)");

$hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
$db->prepare("INSERT OR IGNORE INTO users (username, password) VALUES (?, ?)")
   ->execute(['testuser', $hashedPassword]);

echo "Database initialized.\n";
