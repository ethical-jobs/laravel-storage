<?php

namespace Tests\Integration\Repositories\Database;

use EthicalJobs\Storage\CriteriaCollection;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\Fixtures\Models;
use Tests\Fixtures\Criteria;

class CriteriaTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $repository = new PersonDatabaseRepository;
        
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
        $repository = new PersonDatabaseRepository;

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
        $repository = new PersonDatabaseRepository;
        
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

        $repository = new PersonDatabaseRepository;
        
        $people = $repository
            ->addCriteria(Criteria\OverFifity::class)
            ->find();

        $people->each(function($person) {
            $this->assertTrue($person->age > 50);
        });
    }      
}