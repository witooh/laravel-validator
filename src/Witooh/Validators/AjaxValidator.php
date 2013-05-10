<?php
namespace Witooh\Validators;

class AjaxValidator {

    protected $validatorClassName;
    protected $validator;

    /**
     * @param string $validatorClassName
     * @param array $data
     */
    function __construct($validatorClassName, $data){
        $this->validator = new $validatorClassName($data);
        $this->validatorClassName = $validatorClassName;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function getValidatorClassName()
    {
        return $this->validatorClassName;
    }

    public function passes(){
        return $this->validator->passes();
    }

    public function fails(){
        return $this->validator->fails();
    }

}