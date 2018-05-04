<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Criteria;
use EthicalJobs\Storage\Criteria\CriteriaCollection;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class CriteriaTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $repository = RepositoryFactory::makeDatabase(new Models\Person);
        
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
        $repository = RepositoryFactory::makeDatabase(new Models\Person);

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
        $repository = RepositoryFactory::makeDatabase(new Models\Person);
        
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
        factory(Models\Person::class, 5)
            ->create(['age' => 29]);

        factory(Models\Person::class, 5)
            ->create(['age' => 55]);            

        $repository = RepositoryFactory::makeDatabase(new Models\Person);
        
        $people = $repository
            ->addCriteria(Criteria\OverFifity::class)
            ->find();

        $people->each(function($person) {
            $this->assertTrue($person->age > 50);
        });
    }      
}
