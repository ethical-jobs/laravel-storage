<?php

namespace Tests\Integration\ParameterQueries;

use Mockery;
use Illuminate\Http\Request;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use Tests\Fixtures\RepositoryFactory;

class ParameterQueryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_its_repository()
    {
        $reqeust = Mockery::mock(Request::class);

        $databaseRepository = RepositoryFactory::makeDatabase();

        $paramQuery = new PersonParameterQuery($request, $repository);

        $this->assertEquals($repository, $paramQuery->getRepository());

        $elasticsearchRepository = RepositoryFactory::makeElasticsearch();

        $paramQuery->setRepository($elasticsearchRepository);

        $this->assertEquals($elasticsearchRepository, $paramQuery->getRepository());
    }    
}
