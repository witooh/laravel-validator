<?php
namespace Witooh\Validators;


interface ICustomValidable {
    /**
     * @param string $attribute
     * @param string $value
     * @param array $data
     * @param array $parameters
     * @return bool
     */
    public function validate($attribute, $value, $data, $parameters);
}