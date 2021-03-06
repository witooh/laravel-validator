<?php
namespace Witooh\Validators;

use App;
use Illuminate\Support\Str;

class AbstractLaravelValidator implements IValidatable
{
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


    public function __construct()
    {
        $this->laravelValidatorFactory = App::make('validator');
        $this->errors                  = null;
    }

    /**
     * @param string $value
     * @param mixed $field
     * @param string|null $scenario
     * @return bool
     */
    public function validateField($value, $field, $scenario = null)
    {
        $rule = $this->getRule($scenario);

        if (isset($rule[$field])) {
            $fieldRule  = array($field => $rule[$field]);
            $fieldValue = array($field => $value);
            $this->resolveCustomValidator($fieldValue);
            $validator = $this->laravelValidatorFactory->make($fieldValue, $fieldRule, $this->messages);

            if ($validator->fails()) {
                $this->errors = $validator->errors();

                return false;
            }
        }

        return true;
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
            $this->resolveCustomValidator($input);
            $validator = $this->laravelValidatorFactory->make($input, $rule, $this->messages);

            if ($validator->fails()) {
                $this->errors = $validator->errors();

                return false;
            }
        }

        return true;
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
     * @param array $data
     */
    protected function resolveCustomValidator($data)
    {
        foreach ($this->customValidators as $extend) {

            $ruleName = $this->getRuleName($extend);

            if (!App::offsetExists($extend)) {
                App::singleton($extend, $extend);
            }

            $extend = App::make($extend);

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
        foreach ($merge as $name => $rule) {
            if (is_array($rule)) {
                $rules[$name] = implode('|', $rule);
            } else {
                $rules[$name] = $rule;
            }
        }

        return $rules;
    }
}