<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class DatabaseRepositoryTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        // Via constructor
        $repository = RepositoryFactory::makeDatabase(new Models\Person);
        $this->assertEquals($repository->getStorageEngine(), (new Models\Person)->query());    

        // Via method
        $repository = RepositoryFactory::makeDatabase(new Models\Person);
        $repository->setStorageEngine((new Models\Family)->query());
        $this->assertEquals($repository->getStorageEngine(), (new Models\Family)->query());            
    }    
}
