<?php

namespace Tests\Integration\Repositories\Elasticsearch;

use Tests\Fixtures\RepositoryFactory;

class UpdateCollectionTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $this->expectException(\Exception::class);

        $repository->updateCollection([]);
    }    
}
