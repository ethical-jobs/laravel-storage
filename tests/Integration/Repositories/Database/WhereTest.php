<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class WhereTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $isFluent = $repository
            ->where('first_name', '!=', 'Andrew');

        $this->assertInstanceOf(DatabaseRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        factory(Models\Person::class)->create(['age' => 21]);
        factory(Models\Person::class)->create(['age' => 22]);
        factory(Models\Person::class)->create(['age' => 23]);

        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $result = $repository
            ->where('age', '!=', 22)
            ->find();

        $selectedPeople = $result->pluck('age')->toArray();

        $this->assertEquals($selectedPeople, [
            '21', '23',
        ]);        
    }    
}
