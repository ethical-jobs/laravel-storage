<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Testing\RepositoryFactory;

class FindTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->with('/search/jobs', [])
            ->andReturn($expected)
            ->getMock();

        $repository = RepositoryFactory::makeApi($api, 'search/jobs');

        $response = $repository->find();

        $this->assertEquals($response, $expected);
    }     
}
