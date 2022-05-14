<?php namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function rules(): array
    {
        return array(
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 12]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        );
    }

    public function register(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->save();
    }

    public function tableName(): string
    {
        return "users";
    }

    public function attributes(): array
    {
        return array("name", "email", "password");
    }

    public function primaryKey(): string
    {
        return 'id';
    }


    public function displayName(): string
    {
        return $this->name;
    }

    public function labels(): array
    {
        return [
            'name' => 'نام',
            'email' => 'ایمیل',
            'password' => 'رمزعبور',
            'confirmPassword' => 'تایید رمزعبور',
        ];
    }
}
