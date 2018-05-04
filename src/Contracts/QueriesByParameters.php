<?php

namespace EthicalJobs\Storage\Contracts;

use Illuminate\Http\Request;

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
     * @return ParameterQuery
     */
    public function setRepository(Repository $repository): ParameterQuery;

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
     * @return ParameterQuery
     */
    public function setRequest(Request $request): ParameterQuery;

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
