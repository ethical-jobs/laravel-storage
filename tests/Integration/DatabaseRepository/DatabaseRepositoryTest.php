<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class PersonDatabaseRepositoryTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        // Via constructor
        $repository = new PersonDatabaseRepository;
        $this->assertEquals($repository->getStorageEngine(), (new Models\Person)->query());

        // Via method
        $repository = new PersonDatabaseRepository;
        $repository->setStorageEngine((new Models\Family)->query());
        $this->assertEquals($repository->getStorageEngine(), (new Models\Family)->query());
    }
}
