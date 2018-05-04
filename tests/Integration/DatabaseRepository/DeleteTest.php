<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;

class DeleteTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_delete_an_entity_and_return_it()
    {
        $person = factory(Models\Person::class)->create();

        $this->assertTrue($person->deleted_at === null);

        $repository = new PersonDatabaseRepository; 

        $deleted = $repository->delete($person->id);

        $this->assertTrue($deleted->deleted_at !== null);
    }    
}
