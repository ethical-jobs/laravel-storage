<?php

namespace Tests\Integration\Repositories\Elasticsearch;

class DeleteTest extends \Tests\Integration\Repositories\ElasticsearchTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_delete_an_entity_and_return_it()
    {
        $this->expectException(\Exception::class);

        $repository->delete(123);
    }    
}
