<?php
namespace EthicalJobs\Storage\ParameterQueries;

use Illuminate\Http\Request;
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
     * Request instance
     * 
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Repository instance
     * 
     * @var \EthicalJobs\Storage\Contracts\Repository
     */
    protected $repository; 

    /**
     * Available parameters
     *
     * @var Array
     */
    protected $parameters = [];    

    /**
     * Object constructor
     * 
     * @var \Illuminate\Http\Request $request
     * @var \EthicalJobs\Storage\Contracts\Repository $repository
     * @return void
     */
    public function __construct(Request $request, Repository $repository)
    {
        $this->setRequest($request);

        $this->setRepository($repository);
    }

    /**
     * {@inheritdoc}
     */
    public function find(): iterable
    {
        foreach ($this->parameters as $parameter) {
            if ($this->request->has($parameter)) {

                $value = $this->request->get($parameter);

                $this->$parameter($value);
            }
        }

        return $this->repository->find();
    }

    /**
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
    /**
     * {@inheritdoc}
     */
    public function setRequest(Request $request): QueriesByParameters
    {
        $this->request = $request;
        
        return $this;    
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(): Request       
    {
        return $this->request;
    }
}
