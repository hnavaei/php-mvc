<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginModel extends Model
{
    public string $email = '';
    public string $password = '';

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['email', 'password'];
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function login(): bool
    {
        $user = (new User())->findOneRow(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User with this email doesnt exist');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'User with this password doesnt exist');
            return false;
        }
        return Application::$app->login($user);
    }

    public function labels(): array
    {
        return [
            'email' => 'ایمیل',
            'password' => 'رمزعبور'
        ];
    }

}