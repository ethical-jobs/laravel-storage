<?php

namespace Tests\Integration\Storage\Repositories\Database;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\Foundation\Storage\CriteriaCollection;
use EthicalJobs\SDK\ApiClient;

class CriteriaTest extends \EthicalJobs\Tests\SDK\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $repository = new JobApiRepository(resolve(ApiClient::class));
        
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
        $repository = new JobApiRepository(resolve(ApiClient::class));

        $collection = new CriteriaCollection(['foo' => 'bar']);
        
        $repository->setCriteriaCollection($collection);

        $this->assertEquals($repository->getCriteriaCollection(), $collection);
    }      
}
