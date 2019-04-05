<?php

namespace Tests;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Database\ConsoleServiceProvider;
use Tests\Fixtures\Models;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->withFactories(__DIR__ . '/../database/factories');
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
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
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
        ];
    }
}
