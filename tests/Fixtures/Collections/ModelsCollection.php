<?php

namespace Tests\Fixtures\Collections;

use EthicalJobs\Storage\Collection;
use Tests\Fixtures\Models;

/**
 * Collections test fixture
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class ModelsCollection extends Collection
{
    /**
     * Create a new collection.
     *
     * @return array
     */
    public static function items()
    {
        return [
            'families' => Models\Family::class,
            'people' => Models\Person::class,
            'vehicles' => Models\Vehicle::class,
        ];
    }
}