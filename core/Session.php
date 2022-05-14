<?php namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flash_messages as $key => &$flash_message) {
            $flash_message['isDeleted'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }

    public function setFlashSession(string $key, string $msg)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $msg,
            'isDeleted' => false
        ];
    }

    public function getFlashSession(string $key)
    {
//        foreach ($_SESSION[self::FLASH_KEY] as $keyArr => $item) {
//            return $item[$key];
//        }
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function setSession(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession(string $key)
    {
        return $_SESSION[$key] ?? false;

    }

    public function removeSession(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flash_messages as $key => $flash_message) {
            if ($flash_message['isDeleted'])
                unset($flash_messages[$key]);
        }
        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }
}