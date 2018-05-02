<?php

namespace Tests\Integration\Repositories\Api;

use EthicalJobs\Storage\Criteria\CriteriaCollection;

class CriteriaTest extends \Tests\Integration\Repositories\ApiTestCase
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

        $collection = new CriteriaCollection(['foo' => 'bar']);
        
        $repository->setCriteriaCollection($collection);

        $this->assertEquals($repository->getCriteriaCollection(), $collection);
    }      
}
