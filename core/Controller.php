<?php

declare(strict_types=1);

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewFile)) {
            die("Шаблон '{$view}' не знайдено.");
        }
        require_once $viewFile;
    }
}
