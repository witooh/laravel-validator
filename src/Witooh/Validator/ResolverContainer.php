<?php
namespace Witooh\Validator;

use Illuminate\Support\Facades\Validator;

class ResolverContainer implements IResolverContainer
{
    /**
     * @var array
     */
    protected $resolvers;

    public function __construct()
    {
        $this->resolvers = array();
    }

    /**
     * @param string $resolverName
     */
    public function add($resolverName)
    {
        $this->resolvers[$resolverName] = 1;
    }

    /**
     * @param string $resolverName
     * @return bool
     */
    public function has($resolverName)
    {
        return isset($this->resolvers[$resolverName]) ? true : false;
    }

    /**
     * @param array $resolvers
     * @throws \Exception
     */
    public function resolve(array $resolvers)
    {
        if (!is_array($resolvers)) {
            throw new \InvalidArgumentException;
        }

        foreach ($resolvers as $resolver) {

            try {

                if (!$this->has($resolver)) {

//                    $resolverClass = new \ReflectionClass($resolver);

//                    $this->add($resolver);

                    Validator::resolver(function ($translator, $data, $rules, $messages) use (&$resolver)
                    {
                        return new $resolver(array($translator, $data, $rules, $messages));
                    });       }
            } catch (Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }
}