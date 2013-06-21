<?php
namespace Witooh\Validators;

use Illuminate\Support\Facades\Validator;
use Input;
use App;

class InlineAjaxValidator {

    protected $validatorClassName;
    protected $value;
    protected $validator;
    protected $field;


    /**
     * @param string $validatorClassName
     * @param string $field
     */
    function __construct($validatorClassName, $field){
        $this->value = Input::get($field);

        $this->validator = App::make('validators')->get($validatorClassName);

        $this->validator->setAttributes(array(
                $field=>$this->value
        ));

        $this->validatorClassName = $validatorClassName;
        $this->field = $field;
    }

    public function getField()
    {
        return $this->field;
    }

    /**
     * @return IValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    public function getValidatorClassName()
    {
        return $this->validatorClassName;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function passes(){
        return $this->validator->passes();
    }

    public function fails(){
        return $this->validator->fails();
    }

}