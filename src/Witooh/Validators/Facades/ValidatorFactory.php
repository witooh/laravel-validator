<?php

namespace Witooh\Validators\Facades;

use Illuminate\Support\Facades\Facade;

class ValidatorFactory extends Facade {

    public static function make($validatorClassName, $data){
        return new $validatorClassName($data);
    }
}