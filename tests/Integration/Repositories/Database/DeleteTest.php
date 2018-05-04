<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Tests\Fixtures\Models;
use Tests\Fixtures\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class DeleteTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_delete_an_entity_and_return_it()
    {
        $person = factory(Models\Person::class)->create();

        $this->assertTrue($person->deleted_at === null);

        $repository = RepositoryFactory::makeDatabase(new Models\Person); 

        $deleted = $repository->delete($person->id);

        $this->assertTrue($deleted->deleted_at !== null);
    }    
}
