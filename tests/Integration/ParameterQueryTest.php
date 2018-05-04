<?php

namespace Tests\Integration;

use Mockery;
use Illuminate\Http\Request;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use EthicalJobs\Storage\Testing\RequestFactory;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\Fixtures\Models;

class ParameterQueryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_its_repository()
    {
        $request = Mockery::mock(Request::class);

        $personRepository = new PersonDatabaseRepository;

        $paramQuery = new PersonParameterQuery($request, $personRepository);

        $this->assertEquals($personRepository, $paramQuery->getRepository());
    }    

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_its_request()
    {
        $request = Mockery::mock(Request::class);

        $personRepository = new PersonDatabaseRepository;

        $paramQuery = new PersonParameterQuery($request, $personRepository);

        $this->assertEquals($request, $paramQuery->getRequest());

        $request = Mockery::mock(Request::class);

        $paramQuery->setRequest($request);

        $this->assertEquals($request, $paramQuery->getRequest());
    }       

    /**
     * @test
     * @group Integration
     */
    public function it_queries_by_parameters()
    {
        $expectedPerson= factory(Models\Person::class)->create([
            'age'   => 65,
            'email' => 'andrew@ethicaljobs.com.au',
        ]);
        factory(Models\Person::class)->create([
            'age'   => 45,
            'email' => 'andrew@ethicaljobs.com.au',
        ]);        

        $request = RequestFactory::make('GET', [
            'ages'  => [23,65,55,18],
            'email' => 'andrew@ethicaljobs.com.au',
        ]);

        $personRepository = new PersonDatabaseRepository;

        $paramQuery = new PersonParameterQuery($request, $personRepository);

        $person = $paramQuery
            ->find()
            ->first();

        $this->assertEquals($expectedPerson->id, $person->id);
        $this->assertEquals($expectedPerson->first_name, $person->first_name);
    }             
}
