<?php

namespace Witooh\Validators;


interface IValidatorFactory {

    /**
     * @param string $name
     * @return IValidatable
     */
    public function create($name);
}