<?php
namespace Witooh\Validators;

class ValidatorFactory implements IValidatorFactory
{

    /**
     * @var IResolverContainer
     */
    protected $resolverContainer;

    /**
     * @param IResolverContainer $resolverContainer
     */
    public function __construct(IResolverContainer $resolverContainer)
    {
        $this->resolverContainer = $resolverContainer;
    }

    /**
     * @param string $validatorName
     * @param array $data
     * @return IBaseValidator
     * @throws \ReflectionException
     */
    public function make($validatorName, array $data)
    {
        try {
            $validatorNameClass = new \ReflectionClass($validatorName);

            return $validatorNameClass->newInstanceArgs(array($data, $this->resolverContainer));
        } catch (\Exception $e) {
            throw new \ReflectionException($e->getMessage());
        }
    }

    public function inlineMake()
    {

    }
}