<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\FamilyDatabaseRepository;
use Tests\TestCase;

class WhereHasInTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = new FamilyDatabaseRepository;

        $isFluent = $repository->whereHasIn('people.id', [12, 22]);

        $this->assertInstanceOf(FamilyDatabaseRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_relationship_values()
    {
        $trumps = factory(Models\Family::class)->create();

        factory(Models\Person::class, 7)->create([
            'family_id' => $trumps->id,
        ]);

        $obamas = factory(Models\Family::class)->create();

        factory(Models\Person::class, 4)->create([
            'family_id' => $obamas->id,
        ]);

        $randomTrumps = $trumps->people
            ->random(2)
            ->pluck('id')
            ->toArray();

        $repository = new FamilyDatabaseRepository;

        $result = $repository
            ->whereHasIn('people.id', $randomTrumps)
            ->find();

        foreach ($result as $shouldBeATrump) {
            $this->assertTrue(
                $trumps->people->contains($shouldBeATrump->id)
            );
            $this->assertFalse(
                $obamas->people->contains($shouldBeATrump->id)
            );
        }
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_relationship_values_with_other_fields()
    {
        $trumps = factory(Models\Family::class)->create();

        factory(Models\Person::class)->create([
            'family_id' => $trumps->id,
            'age' => 75,
        ]);
        factory(Models\Person::class)->create([
            'family_id' => $trumps->id,
            'age' => 42,
        ]);

        $obamas = factory(Models\Family::class)->create();

        factory(Models\Person::class)->create([
            'family_id' => $obamas->id,
            'age' => 32,
        ]);
        factory(Models\Person::class)->create([
            'family_id' => $obamas->id,
            'age' => 8,
        ]);

        $repository = new FamilyDatabaseRepository;

        $result = $repository
            ->whereHasIn('people.age', [42, 8])
            ->find();

        foreach ($result as $family) {
            $agesOfMembers = $family->people->pluck('age');

            $this->assertTrue(
                $agesOfMembers->contains(42) || $agesOfMembers->contains(8)
            );
        }
    }
}
