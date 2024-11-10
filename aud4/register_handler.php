<?php
// Започнување на сесија за чување на податоци за сесијата
session_start();

// Вчитување на поврзувањето со базата на податоци
require 'db.php';

// Проверка дали формата е испратена преку POST метода
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Преземање на податоци од формата за корисничко име и лозинка
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Проверка за минимална должина на корисничко име и лозинка
    if (strlen($username) < 3 || strlen($password) < 6) {
        die('Корисничкото име мора да има најмалку 3 карактери, а лозинката најмалку 6.');
    }

    // Хеширање на лозинката за безбедност
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Вметнување на нов корисник во базата на податоци
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
    try {
        // Извршување на SQL записот за вметнување на новиот корисник
        $stmt->execute([':username' => $username, ':password' => $hashedPassword]);

        // Успешна регистрација, прикажување на порака и линк за најава
        echo "Регистрацијата е успешна! <a href='login.php'>Најавете се тука</a>";
    } catch (PDOException $e) {
        // Ако има грешка во вметнувањето (на пример, корисничкото име веќе постои), прикажување на соодветна порака
        if ($e->getCode() == 23000) {
            die("Корисничкото име веќе постои.");
        } else {
            // Прикажување на другите грешки ако не е специфично за уникатноста
            die("Грешка: " . $e->getMessage());
        }
    }
}
?>
