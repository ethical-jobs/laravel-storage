<?php

namespace Tests\Integration\Repositories;

use Tests\Fixtures\Models;
use Illuminate\Database\Eloquent\Model;
use EthicalJobs\Storage\Repositories\DatabaseRepository;
use EthicalJobs\Storage\Contracts\Repository;

class DatabaseTestCase extends \Tests\TestCase
{
    /**
     * Database repository factory
     *
     * @param  ...
     * @return EthicalJobs\Storage\Repositories\DatabaseRepository
     */
    public static function makeRepository(Model $model = null): Repository
    {
        if (is_null($model)) {
            $model = new Models\Person;
        }

        return new DatabaseRepository($model);
    }
}
