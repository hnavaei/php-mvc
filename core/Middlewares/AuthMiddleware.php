<?php

namespace app\core\Middlewares;

use app\core\Application;
use app\core\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions;

    /**
     * @param string[] $array
     */
    public function __construct(array $array)
    {
        $this->actions = $array;
    }

    public function execute()
    {
        if (Application::$app->isGuest() && (in_array(Application::$app->controller->action, $this->actions) || empty($this->actions))) {
            throw new ForbiddenException();
        }
    }
}