<?php

namespace EthicalJobs\Storage;

/**
 * Non specific criteria functionality
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

trait HasCriteria
{
    /**
     * Criteria collection
     *
     * @var EthicalJobs\Storage\Criteria\CriteriaCollection
     */
    protected $criteria;    

    /**
     * {@inheritdoc}
     */
    public function setCriteriaCollection(CriteriaCollection $collection)
    {
    	$this->criteria = $collection;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteriaCollection(): CriteriaCollection
    {
    	return $this->criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function addCriteria(string $criteria)
    {
    	$this->criteria->push($criteria);

    	return $this;
    }   

    /**
     * {@inheritdoc}
     */
    public function applyCriteria() : void
    {    
        foreach ($this->criteria as $criteria) {
            $criteria->apply($this);
        }
    }      
}