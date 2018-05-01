<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class FindTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = factory(Models\Person::class, 10)->create();

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn($expected)
             ->getMock();

        $repository = new DatabaseRepository(new Models\Person);

        $results = $repository
            ->setStorageEngine($query)
            ->find();

        $results->each(function($result) {
            $this->assertInstanceOf(Models\Person::class, $result);
        });
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_throws_exception_on_empty_results()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
        
        $expected = collect([]);

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn($expected)
             ->getMock();

        $repository = new DatabaseRepository(new Models\Person);

        $result = $repository
            ->setStorageEngine($query)
            ->find();

        $this->assertEquals($expected, $result);
    }      
}
