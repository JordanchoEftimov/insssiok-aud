<?php
// Започнување на сесија за чување на податоци за сесијата
session_start();

// Вчитување на потребните фајлови за база на податоци и JWT помошни функции
require 'db.php';  // Вчитување на поврзувањето со базата
require 'jwt_helper.php';  // Вчитување на функциите за работа со JWT токени

// Поставување за ограничувања на обиди
$maxAttempts = 2;  // Максимален број на обиди за најава во дадено време
$lockoutTime = 60;  // Време на блокада во секунди

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка дали корисникот е привремено заклучен
    if (isset($_SESSION['last_attempt_time']) && isset($_SESSION['attempt_count'])) {
        $timePassed = time() - $_SESSION['last_attempt_time'];

        // Ако е поминало времето на блокада, се ресетира бројот на обиди
        if ($timePassed > $lockoutTime) {
            unset($_SESSION['attempt_count']); // Ресетирање на обидите
            unset($_SESSION['last_attempt_time']); // Ресетирање на времето на последниот обид
        }
    }

    // Ако има премногу обиди, се блокира понатамошна најава
    if (isset($_SESSION['attempt_count']) && $_SESSION['attempt_count'] >= $maxAttempts) {
        // Испишување на порака за грешка и прикажување на копче за повторно обидување
        echo "Преголем број на обиди за најава.<br>";
        echo "<a href='login.php'><button>Обидете се повторно</button></a>";
        exit;
    }

    // Преземање на корисничкото име и лозинка од формата
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Преземање на податоци за корисникот од базата на податоци по корисничкото име
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверка дали корисникот постои и дали лозинката е валидна
    if ($user && password_verify($password, $user['password'])) {
        // Ако корисникот и лозинката се точни, креирање на JWT токен
        $token = createJWT($user['id'], $user['username'], $user['role']);

        // Регенирање на сесијата за да се избегнат напади со фиксација на сесијата
        session_regenerate_id(true);

        // Чување на JWT токенот во сесијата
        $_SESSION['jwt'] = $token;

        // Ресетирање на бројот на обиди по успешна најава
        unset($_SESSION['attempt_count']);
        unset($_SESSION['last_attempt_time']);

        // Пренасочување на корисникот на главната страна
        header('Location: index.php');
        exit;  // Завршување на скриптата за да не се извршуваат понатамошни редови код
    } else {
        // Ако најавата не е успешна, следи зголемување на бројот на обиди
        if (!isset($_SESSION['attempt_count'])) {
            $_SESSION['attempt_count'] = 0;  // Иницијализација на бројот на обиди
        }

        // Инкрементирање на бројот на обиди
        $_SESSION['attempt_count']++;

        // Поставување на времето на последниот обид
        $_SESSION['last_attempt_time'] = time();

        // Ако се преминати дозволените обиди, се блокира понатамошен пристап
        if ($_SESSION['attempt_count'] >= $maxAttempts) {
            // Испишување на порака за грешка и прикажување на копче за повторно обидување
            echo "Превисок број на обиди за најава.<br>";
            echo "<a href='login.php'><button>Обидете се повторно</button></a>";
            exit;
        }

        // Ако корисничкото име или лозинката не се точни, прикажување на порака за грешка
        echo "Корисничкото име или лозинката се невалидни.<br>";
        echo "<a href='login.php'><button>Обидете се повторно</button></a>";
        exit;
    }
}
?>
