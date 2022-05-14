<?php namespace app\core;

use app\core\Exceptions\NotFoundException;

class Router
{
    public array $routes;
    public Response $response;
    public Request $request;
    private array $params = [];

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    private function convertToRegex(string $route): string
    {
//        $route = preg_replace('/^\//', '', $route);
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{(\w+)\}/', '(?<\1>[a-z0-9-]+)', $route);
        $route = '/^' . $route . '\/?$/i';
        return $route;
    }

    public function get(string $route, mixed $arr)
    {
        $route = $this->convertToRegex($route);
        $this->routes['get'][$route] = $arr;
    }

    public function post(string $route, mixed $arr)
    {
        $route = $this->convertToRegex($route);
        $this->routes['post'][$route] = $arr;
    }

    public function isMatch(): string
    {
        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        $callbackArr = false;
        foreach ($this->routes[$method] as $patternRoute => $value) {
            if (preg_match_all($patternRoute, $uri, $matches)) {
                $callbackArr = $value;
                foreach ($matches as $key => $match) {
                    if (is_string($key))
                        $this->params[$key] = $match;
                }
            }
        }
        if (!$callbackArr) {
            throw new NotFoundException();
        } else if (is_string($callbackArr)) {
            return $this->showPage($callbackArr);
        } else {
            /** @var Controller $controller */
            $controller = new $callbackArr[0]();
            $controller->action = $callbackArr[1];
            $callbackArr[0] = $controller;
            Application::$app->controller = $controller;
            foreach ($controller->getMiddleware() as $middleware) {
                $middleware->execute();
            }
            return call_user_func($callbackArr, $this->request, $this->response, $this->params);
        }
    }

    public function showPage(string $page, array $params = []): string
    {
        $layout = $this->getLayout();
        $content = $this->getContent($page, $params);
        return str_replace("{content}", $content, $layout);
    }

    public function getContent(string $page, array $params = []): string
    {
        foreach ($params as $key => $val) {
            $$key = $val;
        }
        ob_start();
        include_once Application::$rootPath . "/viewes/$page.php";
        return ob_get_clean();
    }

    public function getLayout(): string
    {
        $layout = Application::$app->layout;
        ob_start();
        include_once Application::$rootPath . "/viewes/layout/$layout.php";
        return ob_get_clean();
    }

}