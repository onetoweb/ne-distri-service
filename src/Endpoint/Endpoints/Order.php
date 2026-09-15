<?php

namespace Onetoweb\NeDistriService\Endpoint\Endpoints;

use Onetoweb\NeDistriService\Endpoint\AbstractEndpoint;

/**
 * Order Endpoint.
 */
class Order extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/orders', $query);
    }
    
    /**
     * @param int $id
     * 
     * @return array
     */
    public function get(int $id): array
    {
        return $this->client->get('/order', [
            'id' => $id
        ]);
    }
    
    /**
     * @param array $data
     * 
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post('/order', $data);
    }
    
    /**
     * @param int $id
     * @param array $data
     * 
     * @return array|null
     */
    public function update(int $id, array $data): ?array
    {
        $data['id'] = $id;
        
        return $this->client->patch('/order', $data);
    }
    
    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function delete(int $id): ?array
    {
        return $this->client->delete('/order', [
            'id' => $id
        ]);
    }
    
    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function send(int $id): ?array
    {
        return $this->client->post('/order-send', [
            'id' => $id
        ]);
    }
    
    /**
     * @param int $id
     * @param array $query = []
     * 
     * @return array|null
     */
    public function label(int $id, array $query = []): ?array
    {
        $query['id'] = $id;
        
        return $this->client->get('/order-stickers', $query);
    }
}
