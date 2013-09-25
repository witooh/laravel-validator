<?php

namespace Witooh\Validators;


use Illuminate\Foundation\Application;

class ValidatorFactory implements IValidatorFactory {

    /**
     * @var Application
     */
    protected $app;
    /**
     * @var string
     */
    protected $namespace;

    public function __construct($namespace="",Application $app)
    {
        $this->namespace = $namespace;
        $this->app = $app;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $name
     * @return IValidatable
     */
    public function create($name)
    {
        return new $name($this->app['validator'], $this->app);
    }
}