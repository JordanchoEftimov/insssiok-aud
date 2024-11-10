<?php
session_start();
require 'jwt_helper.php';

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="mk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контролна табла</title>
    <!-- Link to Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 font-sans">

<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center text-green-600 mb-4">Добредојдовте на контролната табла!</h1>

        <p class="text-center text-lg mb-6">Вашата најава беше успешна. Добредојдовте!</p>

        <div class="text-center">
            <a href="logout_handler.php" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-lg">
                Одјави се
            </a>
        </div>
    </div>
</div>

</body>

</html>
