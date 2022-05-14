<?php namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCH = 'match';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_UNIQUE = 'unique';
    public array $error = [];

    abstract public function labels(): array;

    public function setValue(array $arr): void
    {
        foreach ($arr as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function isValid(): bool
    {
        foreach ($this->rules() as $prop => $rules) {
            $value = $this->{$prop};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) $ruleName = $rule[0];

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($prop, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($prop, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($prop, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($prop, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($prop, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $statement = Application::$app->db->pdo->prepare("SELECT * FROM " . static::tableName() . " WHERE $prop=?");
                    $statement->bindValue(1, $value);
                    $statement->execute();
                    if (count($statement->fetchAll()) > 0) {
                        $this->addErrorForRule($prop, self::RULE_UNIQUE);
                    }
                }
            }
        }
        return empty($this->error);
    }

    public function addErrorForRule(string $prop, string $rule, array $params = [])
    {
        $msg = $this->getErrorMessage()[$rule] ?? '';
        foreach ($params as $key => $val) {
            $msg = str_replace("{{$key}}", $val, $msg);

        }
        $this->error[$prop][] = $msg;
    }

    public function addError(string $prop, string $msg)
    {
        $this->error[$prop][] = $msg;
    }

    public function getErrorMessage(): array
    {
        return array(
            self::RULE_REQUIRED => 'این فیلد ضروری است',
            self::RULE_EMAIL => 'آدرس ایمیل معتبر نمی باشد',
            self::RULE_MIN => ' این فیلد باید حداقل حاوی {min} کاراکتر باشد ',
            self::RULE_MAX => 'این فیلد باید حداقل حاوی {max} کاراکتر باشد',
            self::RULE_MATCH => 'این فیلد باید مشابه {match} باشد',
            self::RULE_UNIQUE => 'کاربری با این ایمیل قبلا ثبت نام کرده است'
        );
    }

    public function hasError(string $prop): bool
    {
        return $this->error[$prop] ?? false;
    }

    public function getFirstErrMsg(string $prop)
    {
        return $this->error[$prop][0] ?? false;
    }

}