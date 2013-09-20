<?php
namespace Witooh\Validators;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use \Illuminate\Validation\Factory as Validator;
use Illuminate\Foundation\Application as App;

class AbstractLaravelValidator implements IValidatable
{
    protected $app;
    /**
     * @var array
     */
    protected $data;
    /**
     * @var \Illuminate\Validation\Factory
     */
    protected $laravelValidatorFactory;
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
    protected $customValidations = array();
    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * @param Validator $laravelValidatorFactory
     * @param App $app
     */
    public function __construct(Validator $laravelValidatorFactory, App $app)
    {
        $this->app = $app;
        $this->laravelValidatorFactory = $laravelValidatorFactory;
        $this->data = null;
        $this->errors = null;
    }

    /**
     * @param array $data
     * @return void
     */
    public function with($data)
    {
        $this->data = $data;
    }

    /**
     * @param string $className
     * @return string
     */
    protected function getRuleName($className){
        return Str::snake(str_replace("CustomValidator", "", array_pop(explode('\\', $className))));
    }

    /**
     * @return bool
     */
    public function passes()
    {
        foreach ($this->customValidations as $extend) {

            $ruleName = $this->getRuleName($extend);

            if(!$this->app->offsetExists($extend)){
                $this->app->singleton($extend, $extend);
            }
            $this->laravelValidatorFactory->extend($ruleName, function($attribute, $value, $parameters) use(&$extend,&$this){
                return $this->app->make($extend)->validate($attribute, $value, $this->data, $parameters);
            });
        }

        $validator = $this->laravelValidatorFactory->make($this->data, $this->rule, $this->messages);

        if($validator->fails())
        {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }

    /**
     * @return \Illuminate\Support\MessageBag|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getRule()
    {
        return $this->rule;
    }
}