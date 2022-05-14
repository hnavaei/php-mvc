<?php namespace app\controllers;

use app\core\Application;
use app\core\controller;
use app\core\Middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginModel;
use app\models\User;

class AuthController extends controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function register(Request $request): string
    {
        $this->setLayout('main_2');
        $registerModel = new User();
        if ($request->isPost()) {
            $registerModel->setValue($request->sanitizeArr());
            if ($registerModel->isValid() && $registerModel->register()) {
                Application::$app->response->redirect("/test/");
                Application::$app->session->setFlashSession('success', 'با موفقیت ثبت شد!');
            }
        }
        return self::showView('register', ['model' => $registerModel]);
    }

    public function login(Request $request)
    {
        $this->setLayout('main_2');
        $loginModel = new LoginModel();
        if ($request->isPost()) {
            $loginModel->setValue($request->sanitizeArr());
            if ($loginModel->isValid() && $loginModel->login()) {
                Application::$app->response->redirect("/test/");
            }
        }
        return self::showView('login', ['model' => $loginModel]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/test/');
    }

    public function profile(): string
    {
        return self::showView('profile');
    }
}