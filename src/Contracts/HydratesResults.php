<?php

namespace EthicalJobs\Storage\Contracts;

/**
 * Adds response hydration functionality
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface HydratesResults
{
    /**
     * Sets the current hydrator instance
     *
     * @param EthicalJobs\Storage\Contracts\Hydrator $hydrator
     * @return $this
     */
    public function setHydrator(Hydrator $hydrator);

    /**
     * Returns the current hydrator instance
     *
     * @return EthicalJobs\Storage\Contracts\Hydrator
     */
    public function getHydrator(): Hydrator;
}