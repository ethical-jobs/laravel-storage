<?php

namespace Tests\Fixtures\Collections;

use Tests\Fixtures\Models;

/**
 * Collections test fixture
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

 class BackWardsCompatible extends \EthicalJobs\Storage\Collection
 {
    /**
     * Create a new collection.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct([
            'families' => Models\Family::class,
            'people' => Models\Person::class,
            'vehicles' => Models\Vehicle::class,
        ]);
    }     
 }