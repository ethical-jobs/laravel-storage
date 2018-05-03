<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class FindTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = factory(Models\Person::class, 10)->create();

        $repository = static::makeRepository(new Models\Person);

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

        $repository = static::makeRepository(new Models\Person);

        $repository->find();
    }      
}
