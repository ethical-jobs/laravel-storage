<?php

namespace Tests\Integration\Repositories;

use Mockery;
use Tests\Fixtures\Models;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\Storage\Repositories\ApiRepository;
use EthicalJobs\Storage\Contracts\Repository;

class ApiTestCase extends \Tests\TestCase
{
    /**
     * Api repository factory
     *
     * @param  ...
     * @return EthicalJobs\Storage\Repositories\ApiRepository
     */
    public static function makeRepository(ApiClient $api = null, string $resource = ''): Repository
    {
        if (is_null($api)) {
            $api = Mockery::mock(ApiClient::class)->shouldIgnoreMissing();
        }        

        return new ApiRepository($api, $resource);
    }
}
