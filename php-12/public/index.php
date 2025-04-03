<?php

require_once __DIR__ . '/../autoload.php';

use App\Models\Post;

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
    <main class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center py-4">Posts</h1>
        
        <aside class="max-w-sm mx-auto my-10">
            <?php
                $show = isset($_GET['show']) ? $_GET['show'] : null;
            ?>
            <a href="/public/i?show=<?php print($show && $show === 'all' ? 'chunked' : 'all'); ?>" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                <?php print($show && $show === 'all' ? 'Only last' : 'Show all'); ?>
            </a>
        </aside>
        
        <section class="flex flex-col gap-4 max-w-sm mx-auto">
            <?php
                $posts = new Post();
                $showed = [];
                $showed = $show && $show === 'all' ? 
                    $posts->searchAll()->getData() : 
                    $posts->searchAll()->getData(9, 0);

                foreach ($showed as $post) { ?>
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <a href="/public/post.php?id=<?php print($post['id']); ?>">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900"><?php print($post['title']); ?></h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700"><?php print(nl2br($post['body'])); ?></p>
                        <a href="/public/post.php?id=<?php print($post['id']); ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                <?php }
            ?>
        </section>
    </main>
</body>
</html>