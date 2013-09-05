<?php
namespace Witooh\Validators;

interface IBaseValidator {

    /**
     * @param array $data
     * @param IResolverContainer $resolveContainer
     */
    public function __construct(array $data, IResolverContainer $resolveContainer);

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