<?php namespace Witooh\Validators;

use Illuminate\Support\ServiceProvider;
use Witooh\Authenticate\Services\Authenticate;
use Witooh\Authenticate\Strategies\BasicHttpStrategy;

class ValidatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('Witooh\Validators\IValidatorFactory', function($app){
            return new ValidatorFactory("", $app);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}