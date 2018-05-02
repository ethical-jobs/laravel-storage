<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class FindByFieldTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $expected = new Models\Person;

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('first_name', 'Andrew')
             ->andReturn(Mockery::self())
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn(collect([$expected]))
             ->getMock();

        $repository = static::makeRepository(new Models\Person);             

        $result = $repository
            ->setStorageEngine($query)
            ->findByField('first_name', 'Andrew');

        $this->assertEquals($expected, $result);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_throws_http_404_exception_when_no_model_found()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $expected = new Models\Person;

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('first_name', 'Andrew')
             ->andReturn(Mockery::self())
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn(null)
             ->getMock();

        $repository = static::makeRepository(new Models\Person);   

        $repository
            ->setStorageEngine($query)
            ->findByField('first_name', 'Andrew');
    }         
}
