<?php
namespace Witooh\Validators;


interface IValidatorContainer {

    /**
     * @param string $key
     * @param string $validator
     */
    public function add($key, $validator);

    /**
     * @param string $key
     * @return IValidator | null;
     */
    public function get($key);

    /**
     * @param $key
     * @return bool
     */
    public function has($key);
}