<?php

namespace Tests\Integration\Repositories\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\Models;
use EthicalJobs\Storage\Testing\RepositoryFactory;
use EthicalJobs\Storage\Repositories\DatabaseRepository;

class FindByFieldTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $person = factory(Models\Person::class)->create();

        $repository = RepositoryFactory::makeDatabase(new Models\Person);             

        $found = $repository
            ->findByField('first_name', $person->first_name);

        $this->assertEquals($person->first_name, $found->first_name);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_throws_http_404_exception_when_no_model_found()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $repository = RepositoryFactory::makeDatabase(new Models\Person);   

        $repository->findByField('first_name', 'Jesus');
    }         
}
