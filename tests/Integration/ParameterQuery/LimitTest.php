<?php

namespace Tests\Integration\ParameterQuery;

use Mockery;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\Fixtures\Models;

class LimitTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_maps_a_limit_parameter()
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
            'limit'  => 2,
        ]);

        $this->assertEquals(2, $people->count());
    }                         
}
