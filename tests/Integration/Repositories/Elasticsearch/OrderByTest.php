<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Mockery;
use Elasticsearch\Client;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Models;

class OrderByTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_orderBy_filter()
    {
        $people = factory(Models\Person::class, 10)->create();

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withArgs(function($query) {
                $this->assertEquals(["order" => "DESC"], array_get($query, 
                    'body.sort.0.age'
                ));
                $this->assertEquals(["order" => "DESC"], array_get($query, 
                    'body.sort.1._score'
                ));                
                return true;
            })
            ->andReturn($this->getSearchResults($people))
            ->getMock();       

        $repository = static::makeRepository($client, new Models\Person);   

        $result = $repository
            ->orderBy('age', 'DESC')
            ->find();

        $this->assertEquals(10, $result->count());        
    }                  
}
