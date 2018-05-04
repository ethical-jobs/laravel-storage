<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use Tests\Fixtures\RepositoryFactory;

class ApiRepositoryTest extends \Tests\Integration\Repositories\ApiTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine_via_constructor()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = RepositoryFactory::makeApi($api);

        $this->assertEquals($repository->getStorageEngine(), $api);             
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine_via_methods()
    {
        $repository = RepositoryFactory::makeApi();

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

        $repository = RepositoryFactory::makeApi($api, 'people');

        $this->assertEquals($repository->getResource(), 'people');    

        $repository = RepositoryFactory::makeApi($api, 'people');

        $repository->setResource('vehicles');

        $this->assertEquals($repository->getResource(), 'vehicles');     
    }        
}
