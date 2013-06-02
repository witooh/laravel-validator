<?php

namespace Witooh\Validators;

use Illuminate\Support\Collection;

class Validators implements IValidatorContainer {

    /**
     * @var \Illuminate\Support\Collection
     */
    private $validators;

    public function __construct(){
        $this->validators = new Collection;
    }

    /**
     * @param string $key
     * @param IValidator $validaotr
     */
    public function add($key, IValidator $validaotr){
        $this->validators->put($key, $validaotr);
    }

    /**
     * @param string $key
     * @return IValidator | null;
     */
    public function get($key){
        return $this->validators->get($key);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key){
        return $this->validators->has($key);
    }

}