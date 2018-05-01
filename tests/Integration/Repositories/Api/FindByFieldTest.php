<?php

namespace EthicalJobs\Tests\SDK\Repositories\JobApiRepository;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\SDK\ApiClient;

class FindByFieldTest extends \EthicalJobs\Tests\SDK\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->with("/jobs?status=APPROVED&limit=1")
            ->andReturn($expected)
            ->getMock();

        $repository = new JobApiRepository($api);

        $response = $repository->findByField('status', 'APPROVED');

        $this->assertEquals($response, $expected);
    }      
}
