<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Mockery;
use Elasticsearch\Client;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\ElasticsearchRepository;

class ElasticsearchRepositoryTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        $client = Mockery::mock(Client::class);

        $repository = static::makeRepository();  

        $repository->setStorageEngine($client);

        $this->assertEquals($repository->getStorageEngine(), $client);            
    }    
}
