<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Mockery;
use Elasticsearch\Client;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Person;

class FindByFieldTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $people = factory(Person::class, 1)->create();

        $searchResults = $this->getSearchResults($people);

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withArgs(function($query) {
                $this->assertEquals('Andrew', array_get($query, 
                    'body.query.bool.filter.0.term.first_name'
                ));
                return true;
            })
            ->andReturn($searchResults)
            ->getMock();            

        $repository = RepositoryFactory::build(new Person, $client);

        $result = $repository->findByField('first_name', 'Andrew');

        $this->assertEquals($result->first_name, $people->first()->first_name);
        $this->assertInstanceOf(Person::class, $result);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_throws_http_404_exception_when_no_model_found()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withAnyArgs()
            ->andReturn($this->getEmptySearchResults())
            ->getMock();            

        $repository = RepositoryFactory::build(new Person, $client);

        $repository->findByField('first_name', 'Andrew');
    }         
}
