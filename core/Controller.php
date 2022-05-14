<?php namespace app\core;

use app\core\Application;
use app\core\Middlewares\BaseMiddleware;


class controller
{
    public string $action;
    public string $layout;
    public array $middleware = [];

    public static function showView(string $page, array $params = []): string
    {
        return Application::$app->router->showPage($page, $params);
    }

    public function setLayout(string $layout): void
    {
        Application::$app->layout = $layout;
    }

    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}