<?php

namespace Tests\Integration\Repositories\Api;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Testing\RepositoryFactory;

class DeleteTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_delete_an_entity_and_return_it()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('delete')
            ->once()
            ->with('/invoices/245')
            ->andReturn($expected)
            ->getMock();

        $repository = RepositoryFactory::makeApi($api, 'invoices');           

        $result = $repository->delete(245);

        $this->assertEquals($expected, $result);
    }    
}
