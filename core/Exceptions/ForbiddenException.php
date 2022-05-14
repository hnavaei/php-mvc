<?php namespace app\core\Exceptions;

use Exception;

class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = 'اجازه دسترسی به این صفحه وجود ندارد';
}