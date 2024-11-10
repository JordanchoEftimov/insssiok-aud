<?php
session_start();
require 'jwt_helper.php';

// Проверка дали JWT токенот постои и е валиден
if (isset($_SESSION['jwt']) && decodeJWT($_SESSION['jwt'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрација</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
<div class="w-full max-w-md bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-semibold text-center mb-6">Регистрирајте се</h2>
    <form action="register_handler.php" method="POST">
        <div class="mb-4">
            <label for="username" class="block text-sm font-semibold">Корисничко име</label>
            <input type="text" name="username" id="username" class="w-full p-2 mt-1 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold">Лозинка</label>
            <input type="password" name="password" id="password" class="w-full p-2 mt-1 border rounded" required>
        </div>
        <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded">Регистрирај се</button>
        <p class="mt-4 text-sm text-center">
            Веќе имате акаунт? <a href="login.php" class="text-blue-500">Најавете се тука</a>
        </p>
    </form>
</div>
</body>
</html>
