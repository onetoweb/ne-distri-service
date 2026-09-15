<?php

namespace Onetoweb\NeDistriService\Endpoint\Endpoints;

use Onetoweb\NeDistriService\Endpoint\AbstractEndpoint;

/**
 * Bulk Endpoint.
 */
class Bulk extends AbstractEndpoint
{
    /**
     * @param array $ids
     * @param array $query = []
     * 
     * @return array
     */
    public function labels(array $ids, array $query = []): array
    {
        $query['ids'] = $ids;
        
        return $this->client->get('/bulk/stickers', $query);
    }
    
    /**
     * @param array $ids
     * 
     * @return array
     */
    public function sendOrders(array $ids): array
    {
        $data['ids'] = $ids;
        
        return $this->client->post('/bulk/sendorders', $data);
    }
}
