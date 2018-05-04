<?php

namespace EthicalJobs\Storage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EthicalJobs\Storage\Contracts;
use EthicalJobs\Storage\Criteria\HasCriteria;
use EthicalJobs\Storage\Criteria\CriteriaCollection;

/**
 * Database repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class DatabaseRepository implements Contracts\Repository, Contracts\HasCriteria
{
    use HasCriteria;

    /**
     * Eloquent model 
     * 
     * @var Illuminate\Database\Eloquent\Model
     */    
    protected $model;

    /**
     * Eloquent model query builder
     * 
     * @var Illuminate\Database\Eloquent\Builder
     */    
    protected $query;    

    /**
     * Object constructor
     *
     * @param Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->setStorageEngine($model->query());

        $this->criteria = new CriteriaCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageEngine()
    {    
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function setStorageEngine($storage)
    {    
        $this->query = $storage;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        if ($id instanceof Model) {
            return $id;
        }

        if ($entity = $this->model->find($id)) {
            return $entity;
        }

        throw new NotFoundHttpException("Entity with id: $id not found");
    }  

    /**
     * {@inheritdoc}
     */
    public function findByField(string $field, $value)
    {
        $results = $this->model->where($field, '=', $value)->get();

        if ($results->isNotEmpty()) {
            return $results->first();
        }

        throw new NotFoundHttpException("Entity with field $field and value $value not found");
    }     

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null): Contracts\Repository
    {
        $this->query->where($field, $operator, $value);

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values): Contracts\Repository
    {
        $this->query->whereIn($field, $values);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, $direction = 'asc'): Contracts\Repository
    {
        $this->query->orderBy($field, $direction);

        return $this;
    }            

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): Contracts\Repository
    {
        $this->query->limit($limit);

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function find(): iterable
    {
        $this->applyCriteria();

        $results = $this->query->get();

        if ($results->isEmpty()) {
            throw new NotFoundHttpException;
        }
        
        return $results;
    }   

    /**
     * {@inheritdoc}
     */
    public function update($id, array $attributes)
    {
        $entity = $this->findById($id);

        $entity->fill($attributes);

        $entity->save();

        return $entity;
    }        

    /**
     * {@inheritdoc}
     */
    public function updateCollection(iterable $entities)
    {
        if (! $entities instanceof Collection) {
            $entities = new Collection($entities);
        }

        $updatedEntities = new Collection;

        foreach ($entities as $id => $entity) {

            $updated = $this->update($id, $entity);

            $updatedEntities->push($updated);
        }

        return $updatedEntities;        
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $entity = $this->findById($id);

        $entity->delete();

        return $entity;
    }        
}