<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/php-mvc/public/assets/css/style.css">
    <link rel="stylesheet" href="http://localhost/php-mvc/public/assets/css/icons.css">
</head>
<body>
<?php
use app\core\Application;
if (Application::$app->session->getFlashSession('success')):?>
    <div class="text-green-700 text-lg">
        <?php echo Application::$app->session->getFlashSession('success') ?>
    </div>
<?php endif; ?>
<div class="container mx-auto w-full">
    {content}
</div>
</body>
</html>
