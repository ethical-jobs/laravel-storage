<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Mockery;
use Elasticsearch\Client;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Models;

class FindTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_searches_the_correct_index()
    {
        $people = factory(Models\Person::class, 10)->create();

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withArgs(function($query) {
                $this->assertEquals('test-index', $query['index']);
                return true;
            })
            ->andReturn($this->getSearchResults($people))
            ->getMock();       

        $repository = static::makeRepository($client, new Models\Person);

        $results = $repository->find();
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_searches_the_correct_document_type()
    {
        $people = factory(Models\Person::class, 10)->create();

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withArgs(function($query) {
                $this->assertEquals('people', $query['type']);
                return true;
            })
            ->andReturn($this->getSearchResults($people))
            ->getMock();       

        $repository = static::makeRepository($client, new Models\Person);  

        $results = $repository->find();
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_throws_excepion_on_empty_results()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withAnyArgs()
            ->andReturn($this->getEmptySearchResults())
            ->getMock();       

        $repository = static::makeRepository($client, new Models\Person);    

        $results = $repository->find();
    }                        
}
