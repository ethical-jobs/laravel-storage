<?php

namespace EthicalJobs\Tests\SDK\Repositories\JobApiRepository;

use Mockery;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\Tests\SDK\Fixtures;

class CollectionsTest extends \EthicalJobs\Tests\SDK\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_patch_a_collection_of_jobs()
    {
        $responses = [
            new Collection(['data' => ['entities' => ['jobs' => ['1111','1111']]]]),
            new Collection(['data' => ['entities' => ['jobs' => ['2222','2222']]]]),
            new Collection(['data' => ['entities' => ['jobs' => ['1111','1111']]]]),
            new Collection(['data' => ['entities' => ['jobs' => ['4444','4444']]]]),                                   
        ];

        $jobs = Fixtures\Requests::jobsCollection(200);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->times(4)
            ->withArgs([
                '/jobs/collection',
                Mockery::on(function ($args) {
                    return $args['jobs']->count() === 50;
                }),
            ])
            ->andReturn($responses[0],$responses[1],$responses[2],$responses[3])
            ->getMock();

        $repository = new JobApiRepository($api);

        $results = $repository->patchCollection($jobs);

        $this->assertInstanceOf(Collection::class, $results);
        
        $this->assertEquals($results->toArray(), [
            'data' => [
                'entities' => [
                    'jobs' => ['1111','1111','2222','2222','1111','1111','4444','4444'],
                ],
            ],
        ]);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_put_a_collection_of_jobs()
    {
        $responses = [
            new Collection(['data' => ['entities' => ['jobs' => ['1111','1111']]]]),
            new Collection(['data' => ['entities' => ['jobs' => ['2222','2222']]]]),
            new Collection(['data' => ['entities' => ['jobs' => ['1111','1111']]]]),
            new Collection(['data' => ['entities' => ['jobs' => ['4444','4444']]]]),                                   
        ];

        $jobs = Fixtures\Requests::jobsCollection(200);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('put')
            ->times(4)
            ->withArgs([
                '/jobs/collection',
                Mockery::on(function ($args) {
                    return $args['jobs']->count() === 50;
                }),
            ])
            ->andReturn($responses[0],$responses[1],$responses[2],$responses[3])
            ->getMock();

        $repository = new JobApiRepository($api);

        $results = $repository->putCollection($jobs);

        $this->assertInstanceOf(Collection::class, $results);

        $this->assertEquals($results->toArray(), [
            'data' => [
                'entities' => [
                    'jobs' => ['1111','1111','2222','2222','1111','1111','4444','4444'],
                ],
            ],
        ]);
    }     
}
