<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class LimitTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = static::makeRepository(new Models\Person);

        $isFluent = $repository->limit(5);

        $this->assertInstanceOf(DatabaseRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        factory(Models\Person::class, 20)->create();

        $repository = static::makeRepository(new Models\Person);

        $result = $repository
            ->limit(15)
            ->find();

        $this->assertEquals(15, $result->count());
    }    
}
