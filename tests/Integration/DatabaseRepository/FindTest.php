<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class FindTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = factory(Models\Person::class, 10)->create();

        $repository = new PersonDatabaseRepository;

        $results = $repository->find();

        $results->each(function ($result) {
            $this->assertInstanceOf(Models\Person::class, $result);
        });

        $this->assertEquals(10, $results->count());
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_empty_iterable_if_results_empty()
    {
        $repository = new PersonDatabaseRepository;

        $results = $repository->find();

        $this->assertEquals(0, $results->count());
    }
}
