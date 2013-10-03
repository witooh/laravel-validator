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
    protected $rule = array();
    /**
     * @var array
     */
    protected $messages = array();
    /**
     * @var array
     */
    protected $customValidators = array();
    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    protected $scenarios = array();

    /**
     * @param Validator $laravelValidatorFactory
     * @param App $app
     */
    public function __construct(Validator $laravelValidatorFactory, App $app)
    {
        $this->app                     = $app;
        $this->laravelValidatorFactory = $laravelValidatorFactory;
        $this->data                    = null;
        $this->errors                  = null;
    }

    /**
     * @param array $input
     * @param string|null $scenario
     * @return bool
     */
    public function validate($input, $scenario = null)
    {
        $rule = $this->getRule($scenario);

        if (!empty($rule)) {
            $this->resolveCustomValidator();
            $validator = $this->laravelValidatorFactory->make($input, $rule, $this->messages);

            if ($validator->fails()) {
                $this->errors = $validator->errors();

                return false;
            }
        }

        return true;
    }


    /**
     * @param array $data
     * @return $this
     */
    public function with($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $className
     * @return string
     */
    protected function getRuleName($className)
    {
        $explodeClass = explode('\\', $className);

        return Str::snake(str_replace("CustomValidator", "", array_pop($explodeClass)));
    }

    /**
     * @param string|null $scenario
     * @return bool
     */
    public function passes($scenario=null)
    {
        $rule = $this->getRule($scenario);

        if (!empty($rule)) {
            $this->resolveCustomValidator();
            $validator = $this->laravelValidatorFactory->make($this->data, $rule, $this->messages);

            if ($validator->fails()) {
                $this->errors = $validator->errors();

                return false;
            }
        }

        return true;
    }

    protected function resolveCustomValidator()
    {
        foreach ($this->customValidators as $extend) {

            $ruleName = $this->getRuleName($extend);

            if (!$this->app->offsetExists($extend)) {
                $this->app->singleton($extend, $extend);
            }

            $data   = $this->data;
            $extend = $this->app->make($extend);

            $this->laravelValidatorFactory->extend($ruleName, function ($attribute, $value, $parameters) use (
                &$extend,
                &$data
            ) {
                return $extend->validate($attribute, $value, $data, $parameters);
            });
        }
    }

    /**
     * @return \Illuminate\Support\MessageBag|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $scenario
     * @return array
     */
    public function getRule($scenario)
    {
        if ($scenario != null && isset($this->scenarios[$scenario])) {
            return $this->concatRule($scenario);
        } else {
            return $this->rule;
        }
    }

    protected function concatRule($scenario)
    {
        $rules = array();
        $merge = array_merge_recursive($this->rule, $this->scenarios[$scenario]);
        foreach($merge as $name=>$rule)
        {
            if(is_array($rule))
            {
                $rules[$name] = implode('|', $rule);
            }else{
                $rules[$name] = $rule;
            }
        }

        return $rules;
    }
}