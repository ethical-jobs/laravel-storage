<?php

namespace EthicalJobs\Storage\Contracts;

/**
 * Criteria interface
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface Criteria
{
    /**
     * Apply criteria to repository query
     *
     * @param EthicalJobs\Storage\Contracts\Repository $repository
     * @return mixed
     */
    public function apply(Repository $repository);
}