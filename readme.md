<h1>Validator Interface</h1>

<h2>Usage/h2>
```php
namespace Domains\Validators;

use Witooh\Validators\IValidator;

class LoginValidator extends IValidator {

    protected $rule = array(
        'username'=>'required',
        'password' => 'required|username_password_exist'
    );

    protected function registerCustomValidators(){
        Validator::extend('username_password_exist', function($attribute, $value, $parameters)
        {
            $credentials = array(
                'username'=>Input::get('username'),
                'password'=>Input::get('password'),
            );

            return Auth::validate($credentials) ? true : false;
        });
    }
}
```

Inline Ajax Validate
```php
if(Request::ajax() && Input::has('inline_validation')){
    $res = new InlineAjaxValidator('LoginValidator',Input::get('field'), Input::get('value'));
}
```

Ajax Validator
```php
if(Request::ajax() && Input::has('inline_validation')){
    $res = new AjaxValidator('LoginValidator',Input::all());
}
```
