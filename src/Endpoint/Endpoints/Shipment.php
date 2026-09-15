<?php

namespace Onetoweb\NeDistriService\Endpoint\Endpoints;

use Onetoweb\NeDistriService\Endpoint\AbstractEndpoint;

/**
 * Shipment Endpoint.
 */
class Shipment extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/shipments', $query);
    }
    
    /**
     * @param array $query = []
     * 
     * @return array
     */
    public function get(array $query = []): array
    {
        return $this->client->get('/shipment', $query);
    }
}
