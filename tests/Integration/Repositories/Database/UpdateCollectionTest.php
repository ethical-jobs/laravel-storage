<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class UpdateCollectionTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_updates_a_collection_of_entities()
    {
        $peopleToUpdate = factory(Models\Person::class, 6)
            ->create()
            ->map(function($person) {
                return [
                    'id'            => $person->id,
                    'first_name'    => 'Andrew',
                    'last_name'     => 'McLagan',
                ];
            })
            ->keyBy('id');

        $repository = RepositoryFactory::makeDatabase(new Models\Person); 

        $updatedPeople = $repository->updateCollection($peopleToUpdate);

        $updatedPeople->each(function($person) {
            $this->assertEquals($person->first_name, 'Andrew');
            $this->assertEquals($person->last_name, 'McLagan');
        });
    }        

    /**
     * @test
     * @group Integration
     */
    public function it_can_accept_arrays_when_updating()
    {
         $peopleToUpdate = factory(Models\Person::class, 6)
            ->create()
            ->map(function($person) {
                return [
                    'id'            => $person->id,
                    'first_name'    => 'Andrew',
                    'last_name'     => 'McLagan',
                ];
            })
            ->keyBy('id')
            ->toArray();

        $repository = RepositoryFactory::makeDatabase(new Models\Person); 

        $updatedPeople = $repository->updateCollection($peopleToUpdate);

        $updatedPeople->each(function($person) {
            $this->assertEquals($person->first_name, 'Andrew');
            $this->assertEquals($person->last_name, 'McLagan');
        });
    }      

    /**
     * @test
     * @group Integration
     */
    public function it_returns_all_updated_entities()
    {
         $peopleToUpdate = factory(Models\Person::class, 6)
            ->create()
            ->map(function($person) {
                return [
                    'id'            => $person->id,
                    'first_name'    => 'Andrew',
                    'last_name'     => 'McLagan',
                ];
            })
            ->keyBy('id');

        $repository = RepositoryFactory::makeDatabase(new Models\Person); 

        $updatedPeople = $repository->updateCollection($peopleToUpdate);

        $updatedPeople->each(function($person) use ($peopleToUpdate) {
            $this->assertTrue($peopleToUpdate->has($person->id));
        });
    }            
}
