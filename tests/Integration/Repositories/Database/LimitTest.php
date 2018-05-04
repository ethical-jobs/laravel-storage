<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class LimitTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = RepositoryFactory::makeDatabase(new Models\Person);

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

        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $result = $repository
            ->limit(15)
            ->find();

        $this->assertEquals(15, $result->count());
    }    
}
