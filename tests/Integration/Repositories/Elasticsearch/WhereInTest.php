<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Mockery;
use Elasticsearch\Client;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Models;

class WhereInTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_whereIn_terms_query()
    {
        $people = factory(Models\Person::class, 10)->create();

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withArgs(function($query) {
                // dd($query);
                $this->assertEquals([34,65,14,21], array_get($query, 
                    'body.query.bool.filter.0.terms.age'
                ));
                return true;
            })
            ->andReturn($this->getSearchResults($people))
            ->getMock();       

        $repository = RepositoryFactory::makeElasticsearch($client, new Models\Person);

        $result = $repository
            ->whereIn('age', [34,65,14,21])
            ->find();

        $this->assertEquals(10, $result->count());        
    }                  
}
