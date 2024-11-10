<?php
// Поврзување со базата
try {
    // sqlite: е драјверот што се користи
    // __DIR__ е магичен константен параметар што ја враќа патеката до директориумот каде што се наоѓа моментално PHP сктриптата.
    $dsn = 'sqlite:' . __DIR__ . '/database.sqlite';
    // Креирање на нов објект за поврзување со базата
    $pdo = new PDO($dsn);
    // Поставување на режимот за грешки на PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Креирање на табела за корисници ако не постои
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL,
        role TEXT NOT NULL
    )";
    $pdo->exec($query);  // Извршување на SQL за креирање на табела
} catch (PDOException $e) {
    // Ако се појави грешка при поврзување, испечатете ја и прекинете го извршувањето на скриптата
    die("Поврзувањето со базата на податоци не успеа: " . $e->getMessage());
}
?>
