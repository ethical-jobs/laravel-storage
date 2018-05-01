<?php

namespace Tests\Integration\Storage\Repositories\Database;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\SDK\ApiClient;

class JobApiRepositoryTest extends \EthicalJobs\Tests\SDK\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        // Via constructor
        $api = resolve(ApiClient::class);
        $repository = new JobApiRepository(resolve(ApiClient::class));
        $this->assertEquals($repository->getStorageEngine(), $api);    

        // Via method
        $api = resolve(ApiClient::class);
        $repository = new JobApiRepository($api);
        $mockApi = Mockery::mock(ApiClient::class);
        $repository->setStorageEngine($mockApi);
        $this->assertEquals($repository->getStorageEngine(), $mockApi);            
    }    
}
