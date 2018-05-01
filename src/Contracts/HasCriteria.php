<?php

namespace EthicalJobs\Storage\Contracts;

use EthicalJobs\Storage\Criteria\CriteriaCollection;

/**
 * Has criteria interface
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface HasCriteria
{
    /**
     * Sets the criteria collection
     * 
     * @param EthicalJobs\Storage\Criteria\CriteriaCollection $collection
     * @return $this
     */
    public function setCriteriaCollection(CriteriaCollection $collection);

    /**
     * Gets the criteria collection
     * 
     * @return EthicalJobs\Storage\Criteria\CriteriaCollection
     */
    public function getCriteriaCollection(): CriteriaCollection;

    /**
     * Push a new criteria onto the collection
     *
     * @param string $criteria
     * @return $this
     */
    public function addCriteria(string $criteria);
}