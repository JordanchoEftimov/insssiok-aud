<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрација</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Регистрирај се</h2>

    <form action="register_handler.php" method="POST" class="space-y-4">
        <div>
            <label for="username" class="block text-gray-600 font-semibold mb-1">Корисничко име:</label>
            <input type="text" name="username" id="username" required
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label for="password" class="block text-gray-600 font-semibold mb-1">Лозинка:</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-md transition duration-150">
            Регистрирај се
        </button>
    </form>

    <p class="text-center text-gray-600 mt-4">
        Веќе имате акаунт? <a href="login.php" class="text-blue-500 hover:underline">Најави се тука</a>
    </p>
</div>
</body>
</html>
