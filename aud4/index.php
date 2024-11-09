<?php
session_start();

// Провера за автентикација, ако нема корисник, го пренасочуваме на страницата за најава
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добредојдовте на Вашиот профил</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-96">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Добредојдовте на Вашиот профил</h1>

        <p class="text-lg text-gray-600 mb-6 text-center">
            Здраво, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!
        </p>

        <div class="text-center">
            <a href="logout_handler.php"
               class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md transition duration-150">
                Одјави се
            </a>
        </div>
    </div>
</div>
</body>
</html>
