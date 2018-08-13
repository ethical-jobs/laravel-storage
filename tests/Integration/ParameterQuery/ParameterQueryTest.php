<?php

namespace Tests\Integration\ParameterQuery;

use Mockery;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
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
        $personRepository = new PersonDatabaseRepository;

        $paramQuery = new PersonParameterQuery($personRepository);

        $this->assertEquals($personRepository, $paramQuery->getRepository());
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

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'ages'  => [23,65,55,18],
            'email' => 'andrew@ethicaljobs.com.au',
        ]);

        $person = $people->first();

        $this->assertEquals($expectedPerson->id, $person->id);
        $this->assertEquals($expectedPerson->first_name, $person->first_name);
    }       
    
    /**
     * @test
     * @group Integration
     */
    public function it_can_call_snake_or_camel_case_param_funcs()
    {
        factory(Models\Person::class)->create([
            'last_name' => 'mclagan',
        ]);

        factory(Models\Person::class)->create([
            'last_name' => 'kisilevsky',
        ]);        

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'last_name'  => 'mclagan',
        ]);

        foreach ($people as $person) {
            $this->assertEquals($person->last_name, 'mclagan');
        }

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'lastName'  => 'mclagan',
        ]);

        foreach ($people as $person) {
            $this->assertEquals($person->last_name, 'mclagan');
        }        
    }     
}