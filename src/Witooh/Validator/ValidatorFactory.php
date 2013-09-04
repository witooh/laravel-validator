<?php
namespace Witooh\Validator;

class ValidatorFactory
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
     * @return object
     * @throws \ReflectionException
     */
    public function make($validatorName, array $data)
    {
        try {
            $validatorNameClass = new \ReflectionClass($validatorName);

            return $validatorNameClass->newInstanceArgs(array($data, $this->resolverContainer));
        } catch (\Exception $e) {
            throw new \ReflectionException;
        }
    }

    public function inlineMake()
    {

    }
}