<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\SDK\ApiClient;

class FindTest extends \EthicalJobs\Tests\SDK\TestCase
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

        $repository = new JobApiRepository($api);

        $response = $repository
            ->find();

        $this->assertEquals($response, $expected);
    }     
}
