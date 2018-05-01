<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\SDK\ApiClient;

class FindByIdTest extends \EthicalJobs\Tests\SDK\TestCase
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

        $repository = new JobApiRepository($api);

        $response = $repository->findById(1337);

        $this->assertEquals($response, $expected);
    }        
}
