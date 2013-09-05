<?php namespace Witooh\Validators;

use Illuminate\Support\ServiceProvider;

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
		$this->app->singleton('Witooh\Validators\IResolverContainer', 'Witooh\Validators\ResolverContainer');
		$this->app->singleton('Witooh\Validators\IValidatorFactory', 'Witooh\Validators\ValidatorFactory');
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