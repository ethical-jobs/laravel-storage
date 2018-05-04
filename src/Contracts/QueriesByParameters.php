<?php

namespace EthicalJobs\Storage\Contracts;

use Illuminate\Http\Request;
use EthicalJobs\Storage\Contracts\QueriesByParameters;
use EthicalJobs\Storage\Contracts\Repository;

/**
 * Parameter query contract
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface QueriesByParameters
{
    /**
     * Sets the repository
     *
     * @param EthicalJobs\Storage\Contracts\Repository
     * @return EthicalJobs\Storage\Contracts\QueriesByParameters
     */
    public function setRepository(Repository $repository): QueriesByParameters;

    /**
     * Returns the repository
     *
     * @return EthicalJobs\Storage\Contracts\Repository
     */
    public function getRepository(): Repository;  

    /**
     * Sets the request
     *
     * @param Illuminate\Http\Request
     * @return EthicalJobs\Storage\Contracts\QueriesByParameters
     */
    public function setRequest(Request $request): QueriesByParameters;

    /**
     * Returns the request
     *
     * @return Illuminate\Http\Request
     */
    public function getRequest(): Request;        

    /**
     * Returns results from the parameter query
     *
     * @return iterable
     */
    public function find(): iterable; 
}
