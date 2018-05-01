<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\SDK\ApiClient;

class WhereTest extends \EthicalJobs\Tests\SDK\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldIgnoreMissing();

        $repository = new JobApiRepository($api);

        $isFluent = $repository
            ->where('status', '=', 'APPROVED');

        $this->assertInstanceOf(JobApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/search/jobs', [
                'status' => 'APPROVED',
            ])
            ->andReturn($expected)
            ->getMock();

        (new JobApiRepository($api))
            ->where('status', '=', 'APPROVED')
            ->find();
    } 

    /**
     * @test
     * @group Unit
     */
    public function its_where_clause_always_uses_the_equals_operator()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/search/jobs', [
                'status' => 'APPROVED',
            ])
            ->andReturn($expected)
            ->getMock();

        (new JobApiRepository($api))
            ->where('status', '>=', 'APPROVED')
            ->find();
    }         
}
