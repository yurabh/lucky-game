<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/../core/',
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Models/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '/index.php') {
    (new RegistrationController())->index();
} elseif ($uri === '/register') {
    (new RegistrationController())->register();
} elseif ($uri === '/page-a') {
    (new GameController())->index();
} else {
    http_response_code(404);
    echo "404 Сторінку не знайдено";
}
