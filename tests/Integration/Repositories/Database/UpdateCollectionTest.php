<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class UpdateCollectionTest extends \Tests\Integration\Repositories\DatabaseTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_updates_a_collection_of_entities()
    {
        $people = factory(Models\Person::class, 6)->create();

        $repository = static::makeRepository(new Models\Person); 

        $toUpdate = factory(Models\Person::class, 6)
            ->create()
            ->map(function($person) {
                return [
                    'first_name'    => 'Andrew',
                    'last_name'     => 'McLagan',
                ];
            });

        $deleted = $repository->udpateCollection($toUpdate);

        $this->assertTrue($deleted->deleted_at !== null);
    }        

    /**
     * @test
     * @group Integration
     */
    public function it_can_accept_arrays_when_updating()
    {
        $jobs = [];

        for ($i = 0; $i < 30; $i++) {
            $jobs[$i] = [
                'id'    => $i, 
                'title' => 'React Developer', 
                'views' => 100
            ];
        }

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->once()
            ->withArgs([
                '/jobs/collection',
                Mockery::on(function ($args) {
                    return $args['jobs']->count() === 30;
                }),
            ])
            ->andReturn(new Collection([]))
            ->getMock();

        $repository = static::makeRepository($api, 'jobs');     

        $repository->updateCollection($jobs);
    }      

    /**
     * @test
     * @group Integration
     */
    public function it_returns_all_updated_entities()
    {
        $jobs = new Collection;

        for ($i = 0; $i < 200; $i++) {
            $jobs->put($i, [
                'id'    => $i, 
                'title' => 'React Developer', 
                'views' => 100
            ]);
        }

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->times(4)
            ->withAnyArgs()
            ->andReturn(...$jobs->chunk(50))
            ->getMock();

        $repository = static::makeRepository($api, 'jobs');     

        $updated = $repository->updateCollection($jobs);

        $this->assertEquals($jobs, $updated);
    }            
}
