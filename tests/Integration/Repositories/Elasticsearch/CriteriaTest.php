<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Mockery;
use Tests\Fixtures\Models;
use Tests\Fixtures\Criteria;
use EthicalJobs\Storage\Criteria\CriteriaCollection;
use EthicalJobs\Storage\Repositories\ElasticsearchRepository;

class CriteriaTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $repository = static::makeRepository();  
        
        $criteria = $repository->getCriteriaCollection();

        $this->assertInstanceOf(CriteriaCollection::class, $criteria);

        $this->assertTrue($criteria->isEmpty());
    }    

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_it_criteria_collection()
    {
        $repository = static::makeRepository();  

        $collection = new CriteriaCollection([
            Criteria\Males::class,
            Criteria\OverFifity::class,
        ]);
        
        $repository->setCriteriaCollection($collection);

        $this->assertEquals($repository->getCriteriaCollection(), $collection);
    }      

    /**
     * @test
     * @group Integration
     */
    public function it_can_add_criteria_items()
    {
        $repository = static::makeRepository();  
        
        $expected = $repository->addCriteria(Criteria\OverFifity::class)
            ->getCriteriaCollection()
            ->get(Criteria\OverFifity::class);

        $this->assertEquals(new Criteria\OverFifity, $expected);
    }  

    /**
     * @test
     * @group Integration
     */
    public function it_can_apply_criteria()
    {
        $overFifties = factory(Models\Person::class, 5)
            ->create(['age' => 55]);        

        $searchResults = $this->getSearchResults($overFifties);

        $client = Mockery::mock(Client::class)
            ->shouldReceive('search')
            ->once()
            ->withAnyArgs()
            ->andReturn($searchResults)
            ->getMock();

        $repository = static::makeRepository();  
        
        $people = $repository
            ->setStorageEngine($client)
            ->addCriteria(Criteria\OverFifity::class)
            ->find();

        $people->each(function($person) {
            $this->assertTrue($person->age > 50);
        });
    }      
}
