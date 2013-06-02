<?php
namespace Witooh\Validators;


interface IValidatorContainer {

    /**
     * @param string $key
     * @param IValidator $validaotr
     */
    public function add($key, IValidator $validaotr);

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