<?php namespace app\core\Form;

use app\core\Model;

class Field extends Form
{

    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_EMAIL = 'email';
    public string $type;

    public function __construct(public Model $model, private string $prop)
    {
        $this->type = self::TYPE_TEXT;
    }

    public function __toString()
    {
        return sprintf("<div class='mt-4'>
         <label class='block'>%s<label>
                 <input type='%s' name='%s'
                     class='w-full border px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600'>
                     <span class='text-red-400'>%s</span>
     </div>", $this->model->labels()[$this->prop], $this->type, $this->prop, $this->model->getFirstErrMsg($this->prop));
    }

    public function setTypePass()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

}