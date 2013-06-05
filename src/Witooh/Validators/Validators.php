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
     * @param string $validator
     */
    public function add($key, $validator){
        $this->validators->put($key, $validator);
    }

    /**
     * @param string $key
     * @return IValidator | null;
     */
    public function get($key){
        $validator = $this->validators->get($key);
        if($validator instanceof IValidator){
            return $validator;
        }else{
            $validator = new $validator();
            $this->validators->put($key, $validator);
            return $validator;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key){
        return $this->validators->has($key);
    }

}