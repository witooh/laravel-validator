<?php
namespace Witooh\Validators;

class InlineAjaxValidator {

    protected $validatorClassName;
    protected $value;
    protected $validator;
    protected $field;


    /**
     * @param string $validatorClassName
     * @param string $field
     * @param mixed $value
     */
    function __construct($validatorClassName, $field, $value){
        $this->validator = new $validatorClassName(array(
            $field=>$value
        ));
        $this->validatorClassName = $validatorClassName;
        $this->value = $value;
        $this->field = $field;
    }

    public function getField()
    {
        return $this->field;
    }

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