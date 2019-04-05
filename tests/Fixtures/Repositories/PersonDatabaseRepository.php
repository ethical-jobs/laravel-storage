<?php

namespace Tests\Fixtures\Repositories;

use EthicalJobs\Storage\Contracts\Repository;
use EthicalJobs\Storage\DatabaseRepository;
use Tests\Fixtures\Models;

/**
 * Person database repository fixture
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class PersonDatabaseRepository extends DatabaseRepository
{
    /**
     * Object constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new Models\Person);
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $term = ''): Repository
    {
        if (strlen($term) > 0) {
            $this->query->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('age', 'like', "%{$term}%");
        }

        return $this;
    }
}