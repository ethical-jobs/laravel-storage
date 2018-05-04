<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Testing\RepositoryFactory;

class UpdateTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->once()
            ->with('/invoices/245', [
                'amount'    => 123.34,
                'payment'   => 'cc',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = RepositoryFactory::makeApi($api, 'invoices');           

        $result = $repository->update(245, [
            'amount'    => 123.34,
            'payment'   => 'cc',
        ]);

        $this->assertEquals($expected, $result);
    }    
}
