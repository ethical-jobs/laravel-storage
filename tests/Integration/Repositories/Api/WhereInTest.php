<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Repositories\ApiRepository;

class WhereInTest extends \Tests\Integration\Repositories\ApiTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = static::makeRepository();

        $isFluent = $repository
            ->whereIn('locations', [1,28,298,23,7]);

        $this->assertInstanceOf(ApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_whereIn_query()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/people', [
                'status' => ['APPROVED','DRAFT'],
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = static::makeRepository($api, 'people');

        $repository
            ->whereIn('status', ['APPROVED','DRAFT'])
            ->find();
    }    
}
