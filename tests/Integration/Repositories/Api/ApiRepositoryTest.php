<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;

class ApiRepositoryTest extends \Tests\Integration\Repositories\ApiTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine_via_constructor()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = static::makeRepository($api);

        $this->assertEquals($repository->getStorageEngine(), $api);             
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine_via_methods()
    {
        $repository = static::makeRepository();

        $api = Mockery::mock(ApiClient::class);

        $repository->setStorageEngine($api);

        $this->assertEquals($repository->getStorageEngine(), $api);           
    }        

    /**
     * @test
     * @group Unit
     */
    public function it_can_get_and_set_its_resource()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = static::makeRepository($api, 'people');

        $this->assertEquals($repository->getResource(), 'people');    

        $repository = static::makeRepository($api, 'people');

        $repository->setResource('vehicles');

        $this->assertEquals($repository->getResource(), 'vehicles');     
    }        
}
