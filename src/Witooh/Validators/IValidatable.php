<?php
namespace Witooh\Validators;


interface IValidatable {
    /**
     * @param array $data
     */
    public function __construct(array $data);

    /**
     * @param string $className
     * @return string
     */
    public function getRuleName($className);

    /**
     * @return bool
     */
    public function passes();

    /**
     * @return bool
     */
    public function failes();

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getRule();
}