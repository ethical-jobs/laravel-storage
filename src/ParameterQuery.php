<?php
namespace EthicalJobs\Storage;

use Carbon\Carbon;
use EthicalJobs\Utilities\Timestamp;
use EthicalJobs\Storage\Contracts\QueriesByParameters;
use EthicalJobs\Storage\Contracts\Repository;

/**
 * Request criteria class
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class ParameterQuery implements QueriesByParameters
{
    /**
     * Repository instance
     * 
     * @var \EthicalJobs\Storage\Contracts\Repository
     */
    protected $repository; 

    /**
     * Object constructor
     * 
     * @var \EthicalJobs\Storage\Contracts\Repository $repository
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * {@inheritdoc}
     */
    public function find(array $parameters): iterable
    {
        foreach ($parameters as $parameter => $value) {
            if (method_exists($this, $parameter)) {
                $this->repository->$parameter($value);
            }
        }

        return $this->repository->find();
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(Repository $repository): QueriesByParameters
    {
        $this->repository = $repository;
        
        return $this;    
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(): Repository
    {
        return $this->repository;
    }

    /**
     * Filter by search term
     *
     * @param mixed $value
     * @return void
     */
    public function q($value)
    {
       $this->repository->search((string) $value);
    }    

    /**
     * Order by field
     *
     * @param mixed $value
     * @return void
     */
    public function orderBy($value)
    {
       $this->repository->orderBy($value);
    }    

    /**
     * Limit query
     *
     * @param mixed $value
     * @return void
     */
    public function limit($value)
    {
       $this->repository->limit($value);
    } 
    
    /**
     * Filter by dateFrom
     *
     * @param mixed $value
     * @return void
     */
    public function dateFrom($value)
    {
       $this->repository->where('created_at', '>=', Timestamp::parse($value));
    } 
    
    /**
     * Filter by dateTo
     *
     * @param mixed $value
     * @return void
     */
    public function dateTo($value)
    {
       $this->repository->where('created_at', '<=', Timestamp::parse($value));
    } 
}
