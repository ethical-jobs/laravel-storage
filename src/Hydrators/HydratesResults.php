<?php

namespace EthicalJobs\Storage\Hydrators;

use EthicalJobs\Storage\Contracts\Hydrator;

/**
 * Adds response hydration functionality
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

trait HydratesResults
{
    /**
     * Hydrator instance
     *
     * @var EthicalJobs\Storage\Contracts\Hydrator
     */
    protected $hydrator;    

    /**
     * {@inheritdoc}
     */
    public function setHydrator(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHydrator(): Hydrator
    {
        return $this->hydrator;
    }   
}