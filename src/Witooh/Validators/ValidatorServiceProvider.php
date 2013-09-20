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
        $this->app->singleton('Balista\Authenticate\Service\IAuthenticate', function ($app) {
            return new Authenticate();
        });

        $this->app->singleton('Balista\Authenticate\Strategies\BasicHttpStrategy', function ($app) {
            return new BasicHttpStrategy($this->app['auth']);
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