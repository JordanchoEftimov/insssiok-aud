<?php
// Вчитување на Composer библиотеки преку autoload
require_once __DIR__ . '/vendor/autoload.php';  // Вчитување на потребните библиотеки преку Composer

use Dotenv\Dotenv;  // Класата за работа со .env фајлови
use Firebase\JWT\JWT;  // Класата за работа со JWT токени
use Firebase\JWT\Key;  // Класата за работа со клучеви при декодирање на JWT

// Креирање на Dotenv објект за работа со .env датотека
$dotenv = Dotenv::createImmutable(__DIR__);

// Вчитување на променливите од .env датотеката
$dotenv->load();

// Функција за креирање на JWT токен
function createJWT($userId, $username, $role): string
{
    $secretKey = $_ENV['JWT_SECRET'];  // Читање на JWT_SECRET од .env фајлот

    // Ако тајниот клуч не е поставен, фрламе исклучок
    if (!$secretKey) {
        throw new Exception("JWT_SECRET not found in environment variables.");
    }

    // Создавање на payload (податоци што ќе бидат вклучени во токенот)
    $payload = [
        'iss' => 'your-website.com', // Издавач на токенот
        'aud' => 'your-website.com', // Публиката на токенот
        'iat' => time(),             // Време кога е издаден токенот (timestamp)
        'exp' => time() + 3600,      // Време на истекување на токенот (1 час)
        'userId' => $userId,         // ID на корисникот
        'username' => $username,     // Име на корисникот
        'role' => $role              // Улога на корисникот
    ];

    // Креирање на JWT токен со користење на тајниот клуч и алгоритмот HS256
    return Firebase\JWT\JWT::encode($payload, $secretKey, 'HS256');  // Враќање на генерираниот токен
}

// Функција за декодирање на JWT токен
function decodeJWT($jwt)
{
    try {
        // Читање на JWT_SECRET од .env фајлот
        $jwtSecret = $_ENV['JWT_SECRET'];
        // Декодирање на JWT токенот и враќање на неговиот payload
        return JWT::decode($jwt, new Key($jwtSecret, 'HS256'));  // Декодирање на токенот со користење на клучот
    } catch (Exception $e) {
        // Ако има грешка при декодирање (некоректен токен), враќаме null
        return null;
    }
}
?>
