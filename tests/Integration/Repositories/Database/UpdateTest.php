<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class UpdateTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $person = factory(Models\Person::class)->create();

        $repository = static::makeRepository(new Models\Person); 

        $updated = $repository->update($person, [
            'first_name'    => 'Andrew',
            'last_name'     => 'McLagan',
        ]);

        $this->assertTrue($updated->first_name === 'Andrew');
        $this->assertTrue($updated->last_name === 'McLagan');
    }    
}
