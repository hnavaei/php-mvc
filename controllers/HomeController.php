<?php namespace app\controllers;

use app\core\controller;

class HomeController extends controller
{

    public static function home(): string
    {
        return self::showView('home');
    }
}