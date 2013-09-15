<?php
namespace Witooh\Validators;

use Illuminate\Support\Facades\Validator as LaravelValidator;
use Illuminate\Support\Str;
use App;

class BaseValidator implements IValidatable
{
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
    protected $messages = array();
    /**
     * @var array
     */
    protected $extends = array();

    public function __construct(array $data)
    {
        foreach ($this->extends as $extend) {

            $ruleName = $this->getRuleName($extend);

            if(!App::offsetExists($extend)){
                App::singleton($extend, $extend);
            }
            LaravelValidator::extend($ruleName, function($attribute, $value, $parameters) use(&$extend,&$data){
                return App::make($extend)->validate($attribute, $value, $data, $parameters);
            });
        }

        $this->laravelValidator = LaravelValidator::make($data, $this->rule, $this->messages);
    }

    /**
     * @param string $className
     * @return string
     */
    public function getRuleName($className){
        return Str::snake(array_pop(explode('\\', $className)));
    }

    /**
     * @return bool
     */
    public function passes()
    {
        return $this->laravelValidator->passes();
    }

    /**
     * @return bool
     */
    public function failes()
    {
        return $this->laravelValidator->fails();
    }

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->laravelValidator->errors();
    }

    /**
     * @return array
     */
    public function getRule()
    {
        return $this->rule;
    }
}