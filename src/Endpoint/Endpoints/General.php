<?php

namespace Onetoweb\NeDistriService\Endpoint\Endpoints;

use Onetoweb\NeDistriService\Endpoint\AbstractEndpoint;

/**
 * General Endpoint.
 */
class General extends AbstractEndpoint
{
    /**
     * @return array
     */
    public function ping(): array
    {
        return $this->client->get('/ping');
    }
}
