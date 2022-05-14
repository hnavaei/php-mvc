<?php namespace app\core;
class Response{
    public function setStatusCone(int $code){
        http_response_code($code);
    }

    public function redirect(string $url){
        header("location:$url");
    }
}