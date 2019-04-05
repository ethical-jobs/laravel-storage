<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class LimitTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = new PersonDatabaseRepository;

        $isFluent = $repository->limit(5);

        $this->assertInstanceOf(PersonDatabaseRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        factory(Models\Person::class, 20)->create();

        $repository = new PersonDatabaseRepository;

        $result = $repository
            ->limit(15)
            ->find();

        $this->assertEquals(15, $result->count());
    }
}
