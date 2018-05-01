<?php

namespace EthicalJobs\Storage\Contracts;

use Traversible;
use Illuminate\Support\Collection;

/**
 * Hydrator contract
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface Hydrator
{
    /**
     * Hydrates collection of entities
     *
     * @param Traversible $collection
     * @return \Illuminate\Support\Collection
     */
    public function hydrateCollection(Traversible $collection): Collection;

    /**
     * Hydrates single entity
     *
     * @param mixed $entity
     * @return mixed
     */
    public function hydrateEntity($entity);    
}
