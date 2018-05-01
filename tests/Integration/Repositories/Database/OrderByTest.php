<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class OrderByTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $query = Mockery::mock(Builder::class)->shouldIgnoreMissing();

        $repository = new DatabaseRepository(new Models\Person);

        $isFluent = $repository
            ->setStorageEngine($query)
            ->orderBy('status', 'asc');

        $this->assertInstanceOf(DatabaseRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('orderBy')
             ->once()
             ->with('status', 'asc')
             ->getMock();

        $repository = new DatabaseRepository(new Models\Person);

        $result = $repository
            ->setStorageEngine($query)
            ->orderBy('status', 'asc');
    }    
}
