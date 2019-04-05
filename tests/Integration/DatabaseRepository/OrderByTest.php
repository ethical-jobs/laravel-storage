<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class OrderByTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = new PersonDatabaseRepository;

        $isFluent = $repository
            ->orderBy('status', 'asc');

        $this->assertInstanceOf(PersonDatabaseRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_OrderBy_query()
    {
        factory(Models\Person::class)->create(['age' => 15]);
        factory(Models\Person::class)->create(['age' => 15]);
        factory(Models\Person::class)->create(['age' => 31]);
        factory(Models\Person::class)->create(['age' => 70]);
        factory(Models\Person::class)->create(['age' => 60]);

        $repository = new PersonDatabaseRepository;

        $result = $repository
            ->orderBy('age', 'asc')
            ->find();

        $agesInOrder = $result->pluck('age')->toArray();

        $this->assertEquals($agesInOrder, [
            '15',
            '15',
            '31',
            '60',
            '70',
        ]);
    }
}
