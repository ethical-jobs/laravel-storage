<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class FindByIdTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_returns_a_model_if_one_is_passed_in()
    {
        $person = factory(Models\Person::class)->create();

        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $result = $repository->findById($person);

        $this->assertEquals($person->id, $result->id);
        $this->assertEquals($person->first_name, $result->first_name);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_id()
    {
        $person = factory(Models\Person::class)->create();

        $repository = RepositoryFactory::makeDatabase(new Models\Person);

        $result = $repository->findById($person->id);

        $this->assertEquals($person->id, $result->id);
        $this->assertEquals($person->first_name, $result->first_name);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_throws_http_404_exception_when_no_model_found()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $repository = RepositoryFactory::makeDatabase(new Models\Person); 

        $repository->findById(1337);
    }         
}
