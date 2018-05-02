<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class WhereInTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $query = Mockery::mock(Builder::class)->shouldIgnoreMissing();

        $repository = static::makeRepository(new Models\Person);

        $isFluent = $repository
            ->setStorageEngine($query)
            ->whereIn('status', ['APPROVED','DRAFT']);

        $this->assertInstanceOf(DatabaseRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('status', ['APPROVED','DRAFT'])
             ->getMock();

        $repository = static::makeRepository(new Models\Person);

        $result = $repository
            ->setStorageEngine($query)
            ->whereIn('status', ['APPROVED','DRAFT']);
    }    
}
