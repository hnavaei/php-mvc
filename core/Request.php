<?php namespace app\core;

class Request{

    public function getUri():string{
        return strtolower($_SERVER['REQUEST_URI']);
    }

    public function getMethod():string{
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost():bool{
        return $this->getMethod() == 'post';
    }
    
    public function isGet():bool{
        return $this->getMethod() == 'get';
    }

    public function sanitizeArr():array{
        $sanitizedArr=[];
        if($this->getMethod() == 'post'){
            foreach($_POST as $key=>$value){
                $sanitizedArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->getMethod() == 'get'){
            foreach($_GET as $key=>$value){
                $sanitizedArr[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $sanitizedArr ;
    }
}