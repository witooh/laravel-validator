<?php
namespace Witooh\Validators;

interface IValidatorFactory {
    /**
     * @param IResolverContainer $resolverContainer
     */
    public function __construct(IResolverContainer $resolverContainer);

    /**
     * @param string $validatorName
     * @param array $data
     * @return IBaseValidator
     */
    public function make($validatorName, array $data);

    public function inlineMake();
}