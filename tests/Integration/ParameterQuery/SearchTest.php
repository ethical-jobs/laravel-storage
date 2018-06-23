<?php

namespace Tests\Integration\ParameterQuery;

use Mockery;
use Illuminate\Http\Request;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use EthicalJobs\Storage\Testing\RequestFactory;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\Fixtures\Models;

class SearchTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_maps_a_search_parameter()
    {
        factory(Models\Person::class)->create([
            'first_name' => 'Sari',
            'last_name' => 'Korin Kisilevsky',
        ]);        

        factory(Models\Person::class)->create([
            'first_name' => 'Werdna',
            'last_name' => 'Ssor Nagalcm',
        ]);    
        
        factory(Models\Person::class)->create([
            'first_name' => 'Divad',
            'last_name' => 'ttocs Nagalcm',
        ]);  
        
        factory(Models\Person::class)->create([
            'first_name' => 'ydnas',
            'last_name' => 'gerg Nagalcm',
        ]);           

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'ages'  => [23,65,55,18],
            'email' => 'andrew@ethicaljobs.com.au',            
        ]);

        $this->assertEquals($expectedPerson->id, $person->id);
        $this->assertEquals($expectedPerson->first_name, $person->first_name);
    }                         
}
