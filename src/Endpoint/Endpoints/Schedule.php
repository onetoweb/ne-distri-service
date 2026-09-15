<?php

namespace Onetoweb\NeDistriService\Endpoint\Endpoints;

use Onetoweb\NeDistriService\Endpoint\AbstractEndpoint;

/**
 * Schedule Endpoint.
 */
class Schedule extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/schedule', $query);
    }
}
