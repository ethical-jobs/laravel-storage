<?php

namespace Tests\Integration\ParameterQuery;

use Carbon\Carbon;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\Fixtures\Models;

class DateFromTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_maps_an_dateFrom_parameter()
    {
        factory(Models\Person::class)->create([
            'first_name' => 'iraS',
            'created_at' => Carbon::now()->addDays(5),
        ]);        

        factory(Models\Person::class)->create([
            'first_name' => 'Werdna',
            'created_at' => Carbon::now()->addDays(5),
        ]);    
        
        factory(Models\Person::class)->create([
            'first_name' => 'Divad',
            'created_at' => Carbon::now()->subDays(3),
        ]);  
        
        factory(Models\Person::class)->create([
            'first_name' => 'ydnas',
            'created_at' => Carbon::now()->subDays(3),
        ]);           

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'dateFrom'  => (string) Carbon::tomorrow(),
        ]);

        $this->assertEquals(2, $people->count());

        foreach ($people as $person) {
            $this->assertTrue($person->created_at->gte(Carbon::tomorrow()));
        }
    }                         
}
