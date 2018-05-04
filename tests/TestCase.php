<?php

namespace Tests;

use Tests\Fixtures\Models;
use Orchestra\Database\ConsoleServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{	
	/**
	 * Setup the test environment.
     *
     * @return void
     */
	protected function setUp(): void
	{
	    parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');        

	    $this->withFactories(__DIR__.'/../database/factories');
	}	

	/**
	 * Define environment setup.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
	    $app['config']->set('elasticsearch.index', 'testing');

	    $app['config']->set('elasticsearch.indexables', [
	        Models\Person::class,
	        Models\Family::class,
	        Models\Vehicle::class,
	    ]);
	}	

	/**
	 * Inject package service provider
	 * 
	 * @param  Application $app
	 * @return Array
	 */
	protected function getPackageProviders($app)
	{
	    return [
	    	ConsoleServiceProvider::class,
	   	];
	}	
}
