<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use Tests\Fixtures\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class WhereInTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $isFluent = $repository
            ->whereIn('status', ['APPROVED','DRAFT']);

        $this->assertInstanceOf(DatabaseRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        factory(Models\Person::class)->create(['age' => 21]);
        factory(Models\Person::class)->create(['age' => 34]);
        factory(Models\Person::class)->create(['age' => 16]);
        factory(Models\Person::class)->create(['age' => 34]);

        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $result = $repository
            ->whereIn('age', [21,34])
            ->find();

        $agesSelected = $result->pluck('age')->toArray();

        $this->assertEquals($agesSelected, [
            '21', '34', '34',
        ]);        
    }    
}
