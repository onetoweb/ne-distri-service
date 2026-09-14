<?php

namespace Onetoweb\NeDistriService\Endpoint;

use Onetoweb\NeDistriService\Client;

/**
 * Abstract Endpoint.
 */
abstract class AbstractEndpoint implements EndpointInterface
{
    /**
     * @param Client $client
     */
    public function __construct(
        protected Client $client
    ) {
        
    }
}
