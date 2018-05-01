<?php

namespace EthicalJobs\Storage\Repositories\Base;

use Traversable;
use Illuminate\Support\Collection;
use EthicalJobs\Storage\Repositories\Repository;
use EthicalJobs\Storage\Repositories\RepositoryCriteria;
use EthicalJobs\Storage\Criteria\CriteriaCollection;
use EthicalJobs\Storage\Criteria\HasCriteria;

/**
 * Api repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ApiRepository implements Repository, RepositoryCriteria
{
    use HasCriteria;

    /**
     * Api client instance
     *
     * @var EthicalJobs\SDK\ApiClient
     */
    protected $api;   

    /**
     * Resource path
     *
     * @var string
     */
    protected $resource;       

    /**
     * Http query vars
     *
     * @var array
     */
    protected $query = [];     

    /**
     * Object constructor
     *
     * @param EthicalJobs\SDK\ApiClient $api
     * @param string $resource
     * @return void
     */
    public function __construct(ApiClient $api, string $resource = '/')
    {
        $this->resource = $resource;

        $this->criteria = new CriteriaCollection;

        $this->setStorageEngine($api); 
    }

    /**
     * Sets the resource path in the API request
     *
     * @param string $resource
     * @return $this
     */
    public function setResource(string $resource = '/'): Repository
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Gets the resource path in the API request
     *
     * @return $this
     */
    public function getResource()
    {
        return $this->resource;
    }      

    /**
     * {@inheritdoc}
     */
    public function getStorageEngine()
    {
        return $this->api;
    }

    /**
     * {@inheritdoc}
     */
    public function setStorageEngine($storage)
    {
        $this->api = $storage;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->api->get("/$this->resource/$id");
    }     

    /**
     * {@inheritdoc}
     */
    public function findByField(string $field, $value)
    {
        return $this->api->get("/$this->resource", [
            'limit' => 1,
            $field  => $value,
        ]);
    }        

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null): Repository
    {
        $this->query[$field] = $value;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values): Repository
    {
        $this->query[$field] = $values;

        return $this;        
    }    

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, string $direction): Repository
    {
        $this->query['orderBy'] = $field;

        $this->query['order'] = $direction;

        return $this;           
    }            

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): Repository
    {
        $this->query['limit'] = $limit;

        return $this;             
    }    

    /**
     * {@inheritdoc}
     */
    public function find(): Traversable
    {
        $this->applyCriteria();
        
        return $this->api->get("/$this->resource", $this->query);
    }           
}