<?php

namespace Tests\Integration\Repositories;

use Tests\Fixtures\Models;
use Elasticsearch\Client;
use ONGR\ElasticsearchDSL\Search;
use EthicalJobs\Elasticsearch\TestingIndexable;
use EthicalJobs\Elasticsearch\Testing\InteractsWithElasticsearch;
use EthicalJobs\Storage\Repositories\ElasticsearchRepository;
use EthicalJobs\Storage\Contracts\Repository;

class ElasticsearchTestCase extends \Tests\TestCase
{
    use InteractsWithElasticsearch;

    /**
     * Elasticsearch repository factory
     *
     * @param  ...
     * @return EthicalJobs\Storage\Repositories\ElasticsearchRepository
     */
    public static function makeRepository(Client $client = null, Indexable $indexable = null, Search $search = null): Repository
    {
        if (is_null($indexable)) {
            $indexable = new Models\Person;
        }

        if (is_null($search)) {
            $search = new Search;
        }

        if (is_null($client)) {
            $client = Mockery::mock(Client::class)->shouldIgnoreMissing();
        }        

        return new ElasticsearchRepository($indexable, $search, $client, 'test-index');
    }
}
