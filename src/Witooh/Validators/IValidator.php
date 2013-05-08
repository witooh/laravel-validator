<?php
/**
 * Created by JetBrains PhpStorm.
 * User: witooh
 * Date: 4/22/13
 * Time: 3:49 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Witooh\Validators;

use Validator;

abstract class IValidator {

    protected $attributes;
    protected $rule;
    public $errors;

    function __construct($attributes){
        $this->attributes = $attributes;
        $this->errors = null;
        $this->registerCustomValidators();
    }

    public function passes(){
        $validator = Validator::make($this->attributes, $this->rule);

        if($validator->passes()) return true;

        $this->errors = $validator->messages();

        return false;
    }

    public function fails(){
        $validator = Validator::make($this->attributes, $this->rule);

        if($validator->passes()) return false;

        $this->errors = $validator->messages();

        return true;
    }

    protected function registerCustomValidators(){

    }

    public function getRule()
    {
        return $this->rule;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
