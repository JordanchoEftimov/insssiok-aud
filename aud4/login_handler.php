<?php
// Започнување на сесија за чување на податоци за сесијата
session_start();

// Вчитување на потребните фајлови за база на податоци и JWT помошни функции
require 'db.php';  // Вчитување на поврзувањето со базата
require 'jwt_helper.php';  // Вчитување на функциите за работа со JWT токени

// Проверка дали формата е испратена преку POST метода
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Преземање на корисничко име и лозинка од формата
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Преземање на податоци за корисникот од базата на податоци по корисничкото име
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);  // Враќање на податоци за корисникот како асоцијативна низа

    // Проверка дали корисникот постои и дали лозинката е валидна
    if ($user && password_verify($password, $user['password'])) {
        // Ако корисникот и лозинката се точни, креирање на JWT токен
        $token = createJWT($user['id'], $user['username'], $user['role']);

        // Чување на JWT токенот во сесијата
        $_SESSION['jwt'] = $token;

        // Пренасочување на корисникот на главната страна
        header("Location: index.php");
        exit;  // Затворање на скриптата за да не се извршуваат понатамошни редови код
    } else {
        // Ако корисничкото име или лозинката се неточни, прикажување на порака за грешка
        die("Корисничкото име или лозинката се невалидни.");
    }
}
?>
