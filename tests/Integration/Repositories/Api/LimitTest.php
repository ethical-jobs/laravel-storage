<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Repositories\ApiRepository;
use EthicalJobs\Storage\Testing\RepositoryFactory;

class LimitTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = RepositoryFactory::makeApi();

        $isFluent = $repository->limit(15);

        $this->assertInstanceOf(ApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_limit_query()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/search/jobs', [
                'limit' => 15,
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = RepositoryFactory::makeApi($api, 'search/jobs');            

        $repository
            ->limit(15)
            ->find();
    }    
}
