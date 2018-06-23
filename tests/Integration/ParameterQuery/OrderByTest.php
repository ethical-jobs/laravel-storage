<?php

namespace Tests\Integration\ParameterQuery;

use Mockery;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\Fixtures\Models;

class OrderByTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_maps_an_orderBy_parameter()
    {
        factory(Models\Person::class)->create([
            'first_name' => 'iraS',
            'age' => 44,
        ]);        

        factory(Models\Person::class)->create([
            'first_name' => 'Werdna',
            'age' => 34,
        ]);    
        
        factory(Models\Person::class)->create([
            'first_name' => 'Divad',
            'age' => 36,
        ]);  
        
        factory(Models\Person::class)->create([
            'first_name' => 'ydnas',
            'age' => 38,
        ]);           

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'orderBy'  => 'age',
        ]);

        $this->assertEquals('iraS', $people[3]->first_name);
        $this->assertEquals('ydnas', $people[2]->first_name);
        $this->assertEquals('Divad', $people[1]->first_name);
        $this->assertEquals('Werdna', $people[0]->first_name);
    }                         
}
