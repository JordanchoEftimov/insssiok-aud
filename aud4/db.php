<?php
// db.php - Подесување на база на податоци со PDO за користење на SQLite

try {
    // Создавање на конекција кон SQLite базата на податоци. Префиксот `sqlite:` кажува на PDO да користи SQLite драјвер
    $pdo = new PDO('sqlite:' . __DIR__ . '/database.sqlite');

    // Поставување на PDO режимот за грешки за подобро дебагирање
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Креирање на табелата `users` доколку не постои. Табелата чува податоци за корисници
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    )");

} catch (PDOException $e) {
    // При проблем со конекцијата, се прекинува скриптата и се покажува грешката
    die("Поврзување на базата неуспешно: " . $e->getMessage());
}
?>
