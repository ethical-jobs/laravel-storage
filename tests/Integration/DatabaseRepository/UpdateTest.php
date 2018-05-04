<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;

class UpdateTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $person = factory(Models\Person::class)->create();

        $repository = new PersonDatabaseRepository; 

        $updated = $repository->update($person, [
            'first_name'    => 'Andrew',
            'last_name'     => 'McLagan',
        ]);

        $this->assertTrue($updated->first_name === 'Andrew');
        $this->assertTrue($updated->last_name === 'McLagan');
    }    
}
