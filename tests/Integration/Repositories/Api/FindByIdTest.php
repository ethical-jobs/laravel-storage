<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Testing\RepositoryFactory;

class FindByIdTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_id()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->with("/jobs/1337")
            ->andReturn($expected)
            ->getMock();

        $repository = RepositoryFactory::makeApi($api, 'jobs');

        $response = $repository->findById(1337);

        $this->assertEquals($response, $expected);
    }        
}
