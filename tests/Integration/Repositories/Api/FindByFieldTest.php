<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;

class FindByFieldTest extends \Tests\Integration\Repositories\ApiTestCase
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
            ->with('/jobs', [
                'limit'     => 1,
                'status'    => 'APPROVED',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = static::makeRepository($api, 'jobs');

        $response = $repository->findByField('status', 'APPROVED');

        $this->assertEquals($response, $expected);
    }      
}
