<?php

namespace Witooh\Validators;

use Illuminate\Support\Facades\Validator;

abstract class IValidator
{

    protected $attributes;
    protected $rule;
    public $errors;

    function __construct($attributes = null)
    {
        $this->attributes = $attributes ? : null;
        $this->errors     = null;
        $this->registerCustomValidators();
    }

    public function passes()
    {
        $validator = Validator::make($this->attributes, $this->rule);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->messages();

        return false;
    }

    public function fails()
    {
        $validator = Validator::make($this->attributes, $this->rule);

        if ($validator->passes()) {
            return false;
        }

        $this->errors = $validator->messages();

        return true;
    }

    protected function registerCustomValidators()
    {

    }

    public function getRule($field = null)
    {
        if($field == null){
            return $this->rule;
        }else{
            return $this->rule[$field] ?: null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setRule(array $rule){
        $this->rule = $rule;
    }

    public function inlineValidate($field){

        $value = \Input::get($field);

        if(isset($value)){

            $validator = Validator::make(\Input::all(), array($field=>$this->getRule($field)));

            if ($validator->passes()) {
                return true;
            }

            $this->errors = $validator->messages();

            return $this->errors->getMessages()[$field][0];
        }

        throw new \UnexpectedValueException();
    }

}