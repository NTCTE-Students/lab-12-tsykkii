<?php

require_once __DIR__ . '/../autoload.php';

use App\Models\Post;
use App\Models\User;

if (!$_GET['id']) {
    header('Location: /');
    exit();
}

$post = (new Post())
    -> searchById((int) $_GET['id']);
if (!$post -> getData()) {
    header('Location: /');
    exit();
}

$user = new User();
$userData = $user->getUserById($post->getData()['userId']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="./assets/main.css">
</head>
<body>
<main class="container max-w-sm mx-auto p-6">
    <h1 class="text-4xl font-bold text-center py-4"><?php echo htmlspecialchars($post->getData()['title']); ?></h1>
    <aside class="max-w-sm mx-auto my-10">
        <a href="/public/index.php" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Return back</a>
    </aside>
    <section class="max-w-sm">
        <p><?php echo nl2br(htmlspecialchars($post->getData()['body'])); ?></p>
    </section>
    <?php if ($userData): ?>
        <section class="max-w-sm mt-6">
            <h3 class="text-xl font-semibold font-bold">Автор: <?php echo htmlspecialchars($userData['name']); ?></h3>
            <p class="font-normal">Email: <?php echo htmlspecialchars($userData['email']); ?></p>
        </section>
    <?php else: ?>
        <section class="max-w-sm mt-6">
            <p>Информация об авторе не найдена.</p>
        </section>
    <?php endif; ?>

</main>
</body>
</html>