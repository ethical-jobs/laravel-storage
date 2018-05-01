<?php

namespace EthicalJobs\Storage\Hydrators\Elasticsearch;

use Traversible;
use ArrayObject;
use Illuminate\Support\Collection;

/**
 * Hydrates ArrayObjects from elasticsearch results
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ObjectHydrator implements Hydrator
{
    /**
     * Indexable document type
     *
     * @param App\Services\Elasticsearch\Indexable
     */
    protected $indexable;

    /**
     * {@inheritdoc}
     */
    public function hydrateCollection(Traversible $collection): Collection;
    {
        $this->indexable = $indexable;

        if (empty($response)) {
            return new Collection;
        }

        $items = $response['hits']['hits'] ?? [];

        $results = [];

        foreach ($items as $hit) {
            $results[] = $this->hydrateRecursive($hit);
        }

        return new Collection($results);
    }

    /**
     * {@inheritdoc}
     */
    public function hydrateEntity($entity)
    {
        return new ArrayObject($hit, ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Hydrates a elastic hit
     *
     * @param Array $item
     * @return ArrayObject
     */
    protected function hydrateRecursive(Array $item)
    {
        $relations = $this->indexable->getDocumentRelations();

        $hit = $item['_source'] ?? [];

        $hit['_score'] = $item['_score'] ?? 0;
        $hit['_isDocument'] = true;

        $relationHits = [];

        foreach ($relations as $relation) {
            if (isset($hit[$relation]) && is_array($hit[$relation])) {
                $relationHits[$relation] = $this->hydrateEntity($hit[$relation]);
            }
        }

        $hit = array_merge($hit, $relationHits);

        return new ArrayObject($hit, ArrayObject::ARRAY_AS_PROPS);
    }
}
