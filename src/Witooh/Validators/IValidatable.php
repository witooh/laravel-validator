<?php
namespace Witooh\Validators;


interface IValidatable {
    /**
     * @param $data
     * @return $this
     */
    public function with($data);

    /**
     * @return bool
     */
    public function passes();

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getRule();
}