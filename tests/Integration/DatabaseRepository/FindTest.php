<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;

class FindTest extends \Tests\TestCase
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

        $results->each(function($result) {
            $this->assertInstanceOf(Models\Person::class, $result);
        });

        $this->assertEquals(10, $results->count());
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_throws_exception_on_empty_results()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $repository = new PersonDatabaseRepository;

        $repository->find();
    }      
}
