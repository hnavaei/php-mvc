<?php namespace app\core;

use app\core\Request;
use app\core\Router;
use app\models\User;

class Application
{
    public static string $rootPath;
    public string $layout = 'main';
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public User $userModel;
    public ?DbModel $user;

    public static $app;
    public Database $db;

    public function __construct($root, array $setup)
    {
        self::$rootPath = $root;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($setup['db']);
        $this->session = new Session();


        $primaryValue = $this->session->getSession('user');
        if ($primaryValue) {
            $primaryKey = (new $setup['userClass'])->primaryKey();
            $this->user = (new $setup['userClass'])->findOneRow([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run(): void
    {
        try {
            echo $this->router->isMatch();
        } catch (\Exception $e) {
            $this->layout = 'main_2';
            $this->response->setStatusCone($e->getCode());
            echo Application::$app->router->showPage('error', ['error' => $e]);
        }
    }

    public function login(UserModel $user): bool
    {
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->setSession('user', $primaryValue);
        return true;
    }

    public function isGuest(): bool
    {
        return !$this->user;
    }

    public function logout()
    {
        $this->session->removeSession('user');
        $this->user = null;
    }

}