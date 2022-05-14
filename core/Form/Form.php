<?php namespace app\core\Form;

use app\core\Model;

class Form
{

    public static function startForm(string $method, string $action = ''): Form
    {
        echo "<form method='$method' action='$action' class='rtl-grid text-right'>";
        return new Form();
    }

    public static function endForm(): string
    {
        return "</form>";
    }

    public static function newField(Model $model, string $prop): Field
    {
        return new Field($model, $prop);
    }

}