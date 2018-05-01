<?php

namespace EthicalJobs\Storage\Repositories;

use Traversable;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Storage\Contracts;
use EthicalJobs\Storage\Criteria\HasCriteria;
use EthicalJobs\Storage\Hydrators\HydratesResults;
use EthicalJobs\Storage\Hydrators\Elasticsearch\ObjectHydrator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Elasticsearch repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ElasticsearchRepository implements Contracts\Repository, Contracts\HasCriteria, Contracts\HydratesResults
{
    use HasCriteria, HydratesResults;

    /**
     * Elasticsearch client
     * 
     * @var Elasticsearch\Client
     */
    protected $client;

    /**
     * Name of the working Elasticsearch index
     * 
     * @var string
     */    
    protected $indexName;
    
    /**
     * Indexable model 
     * 
     * @var EthicalJobs\Elasticsearch\Indexable
     */    
    protected $indexable;
    
    /**
     * Elasticsearch query DSL
     * 
     * @var ONGR\ElasticsearchDSL\Search
     */    
    protected $search;

    /**
     * Object constructor
     *
     * @param \EthicalJobs\Elasticsearch\Indexable $indexable
     * @param \ONGR\ElasticsearchDSL\Search $search
     * @param \Elasticsearch\Client $client
     * @param string $indexName
     * @return void
     */
    public function __construct(Indexable $indexable, Search $search, Client $client, string $indexName = 'test-index')
    {
        $this->indexable = $indexable;

        $this->search = $search;

        $this->indexName = $indexName;

        $this->client = $this->setStorageEngine($client);

        $this->setHydrator(new ObjectHydrator);
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageEngine()
    {    
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function setStorageEngine($storage)
    {    
        $this->client = $storage;

        return $this;
    }        

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        $query = new TermLevel\TermQuery('id', $id);

        $this->search->addQuery($query, BoolQuery::FILTER);        

        return $this->asModels()->find()->first();
    }  

    /**
     * {@inheritdoc}
     */
    public function findByField(string $field, $value)
    {
        $query = new TermLevel\TermQuery($field, $value);

        $this->search->addQuery($query, BoolQuery::FILTER);        

        return $this->asModels()->find()->first();
    }     

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null): Repository
    {
        switch ($operator) {
            case '<=':
            case '>=':
            case '<':
            case '>':
                $query = new TermLevel\RangeQuery($field, [$operator => $value]);
                $bool = BoolQuery::FILTER;
                break;
            case 'like':
                $query = new TermLevel\WildcardQuery($field, str_replace('%', '*', $value));
                $bool = BoolQuery::FILTER;
                break;    
            case '!=':
                $query = new TermLevel\TermQuery($field, $value);
                $bool = BoolQuery::MUST_NOT;
                break; 
            case '=':
            default:
                $query = new TermLevel\TermQuery($field, $value ? $value : $operator);
                $bool = BoolQuery::FILTER;
                break;                                             
        }

        $this->search->addQuery($query, $bool); 

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values): Repository
    {
        $query = new TermLevel\TermsQuery($field, $values);

        $this->search->addQuery($query, BoolQuery::FILTER);        

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, $direction = 'asc'): Repository
    {
        $this->search->addSort(new FieldSort($field, $direction));

        $this->search->addSort(new FieldSort('_score', $direction));  

        return $this;
    }               

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): Repository
    {
        $this->search->setSize($limit);

        return $this;
    }                      

    /**
     * {@inheritdoc}
     */
    public function find(): Traversable
    {
        $response = $this->client->search([
            'index' => $this->indexName,
            'type'  => $this->indexable->getDocumentType(),
            'body'  => $this->search->toArray(),
        ]);

        if ($response['hits']['total'] < 1) {
            throw new NotFoundHttpException;
        }

        return $this->getHydrator()
            ->setIndexable($this->indexable)
            ->hydrateCollection($response);
    }   
}