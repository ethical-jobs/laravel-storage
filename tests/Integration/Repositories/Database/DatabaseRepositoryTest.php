<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class DatabaseRepositoryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        // Via constructor
        $repository = new DatabaseRepository(new Models\Person);
        $this->assertEquals($repository->getStorageEngine(), (new Models\Person)->query());    

        // Via method
        $repository = new DatabaseRepository(new Models\Person);
        $repository->setStorageEngine((new Models\Family)->query());
        $this->assertEquals($repository->getStorageEngine(), (new Models\Family)->query());            
    }    
}
