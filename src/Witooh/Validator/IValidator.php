<?php
namespace Witooh\Validator;

interface IValidator {
    /**
     * @param IResolverContainer $resolverContainer
     */
    public function __construct(IResolverContainer $resolverContainer);

    /**
     * @param string $validatorName
     * @param array $data
     * @return mixed
     */
    public function make($validatorName, array $data);

    public function inlineMake();
}