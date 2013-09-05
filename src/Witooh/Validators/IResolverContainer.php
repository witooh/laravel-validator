<?php
namespace Witooh\Validators;

interface IResolverContainer
{
    public function __construct();

    /**
     * @param string $resolverName
     */
    public function add($resolverName);

    /**
     * @param string $resolverName
     * @return bool
     */
    public function has($resolverName);

    /**
     * @param array $resolvers
     */
    public function resolve(array $resolvers);

    /**
     * @return array
     */
    public function getResolvers();
}