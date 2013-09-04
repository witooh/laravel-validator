<?php
namespace Witooh\Validator;

use Illuminate\Support\Facades\Validator as LaravelValidator;

class BaseValidator implements IBaseValidator {

    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $laravelValidator;
    /**
     * @var array
     */
    protected $rule;
    /**
     * @var array
     */
    protected $resolvers = array();

    /**
     * @param array $data
     * @param IResolverContainer $resolveContainer
     */
    public function __construct(array $data, IResolverContainer $resolveContainer){
        $resolveContainer->resolve($this->resolvers);
        $this->laravelValidator = LaravelValidator::make($data, $this->rule);
    }

    /**
     * @return bool
     */
    public function passes(){
        return $this->laravelValidator->passes();
    }

    /**
     * @return bool
     */
    public function failes(){
        return $this->laravelValidator->fails();
    }

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors(){
        return $this->laravelValidator->errors();
    }

    /**
     * @return array
     */
    public function getRule(){
        return $this->rule;
    }
}