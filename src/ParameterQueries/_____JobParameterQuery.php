<?php
namespace EthicalJobs\Storage\Criteria;

use EthicalJobs\Storage\Contracts;

/**
 * 
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class JobParameterQuery extends ParameterQuery
{
    /**
     * Available parameters
     *
     * @var Array
     */
    protected $parameters = [
        'organisations',
        'categories',   
        'workTypes',    
        'sectors',      
        'locations',    
        'status',       
        'featured',     
        'archived',     
        'expired',      
        'q',            
        'orderBy',      
        'limit',        
        'dateFrom',     
        'dateTo',       
        'expiresFrom',  
        'expiresTo',    
    ];    

    /**
     * [organisations] filter by organisation ids
     *
     * @param mixed $value
     * @return void
     */
    public function organisations($value)
    {
        $value = is_array($value) ? $value : [$value];

        $this->repository->whereIn('organisation_id', $value);
    }    
}
