<?php
namespace EthicalJobs\Storage\Criteria;

use EthicalJobs\Storage\Contracts;

/**
 * Base request criteria class
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract ParameterQuery implements Contracts\Criteria
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
     * @var \Illuminate\Http\Request
     * @return void
     */
    public function __construct(Request $request, Repository $repository)
    {
        $this->request = $request;

        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function find()
    {
        foreach ($this->parameters as $parameter) {
            if ($this->request->has($parameter)) {

                $value = $this->request->get($parameter);

                $this->$parameter($value);
            }
        }

        return $this->repository->find();
    }
}
