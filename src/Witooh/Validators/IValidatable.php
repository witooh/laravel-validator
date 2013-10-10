<?php
namespace Witooh\Validators;


interface IValidatable {

    /**
     * @param array $input
     * @param string|null $scenario
     * @return bool
     */
    public function validate($input, $scenario=null);

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors();

    /**
     * @param string $scenario
     * @return array
     */
    public function getRule($scenario);

    /**
     * @param string $value
     * @param mixed $field
     * @param string|null $scenario
     * @return bool
     */
    public function validateField($value, $field, $scenario = null);
}