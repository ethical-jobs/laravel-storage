<?php

namespace Tests\Integration;

use Tests\Fixtures\Criteria;
use EthicalJobs\Storage\CriteriaCollection;

class CriteriaCollectionTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_creates_keyed_instances_when_pushing_new_criteria()
    {
        $collection = new CriteriaCollection;

        $collection
            ->push(Criteria\OverFifity::class)
            ->push(Criteria\Males::class);

        $this->assertEquals($collection->toArray(), [
            Criteria\OverFifity::class   => $collection->first(),
            Criteria\Males::class        => $collection->last(),
        ]);
    }    
}
