<?php

namespace Onetoweb\NeDistriService;

use Onetoweb\NeDistriService\Endpoint\Endpoints;
use Onetoweb\NeDistriService\Exception\PrivateKeyFileException;
use Onetoweb\NeDistriService\Config\Method;
use Onetoweb\NeDistriService\Token;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use DateTime;
use Closure;

/**
 * Ne Distri Service Api Client.
 */
#[\AllowDynamicProperties]
class Client
{
    /**
     * Base href
     */
    public const BASE_HREF = 'https://orders.ne.nl/api/v1';
    
    /**
     * @var string
     */
    private string $nonce;
    
    /**
     * @var Token
     */
    private Token $token;
    
    /**
     * @var Closure
     */
    private Closure $tokenUpdateCallback;
    
    /**
     * @param string $username
     * @param string $privateKeyPath
     */
    public function __construct(
        
        #[\SensitiveParameter]
        private string $username,
        
        #[\SensitiveParameter]
        private string $privateKeyPath
    ) {
        // check file
        $this->checkFile();
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @throws PrivateKeyFileException if a private key path does not exists
     * @throws PrivateKeyFileException if a private key is not a file
     * @throws PrivateKeyFileException if a private key is not a readable
     * 
     * @return void
     */
    private function checkFile(): void
    {
        if (!file_exists($this->privateKeyPath)) {
            throw new PrivateKeyFileException("file {$this->privateKeyPath} does not exists");
        }
        
        if (!is_file($this->privateKeyPath)) {
            throw new PrivateKeyFileException("{$this->privateKeyPath} is not a file");
        }
        
        if (!is_readable($this->privateKeyPath)) {
            throw new PrivateKeyFileException("{$this->privateKeyPath} is not a readable");
        }
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        foreach (Endpoints::list() as $name => $class) {
            $this->{$name} = new $class($this);
        }
    }
    
    /**
     * @param Closure $tokenUpdateCallback
     */
    public function setTokenUpdateCallback(Closure $tokenUpdateCallback) {
        $this->tokenUpdateCallback = $tokenUpdateCallback;
    }
    
    /**
     * @param Token $token
     */
    public function setToken(Token $token)
    {
        $this->token = $token;
    }
    
    /**
     * @param string $endpoint
     * 
     * @return string
     */
    public function getUrl(string $endpoint): string
    {
        return self::BASE_HREF . '/' . ltrim($endpoint, '/');
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return array
     */
    public function get(string $endpoint, array $query = []): array
    {
        return $this->request(Method::GET, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return array
     */
    public function post(string $endpoint, array $data = []): array
    {
        return $this->request(Method::POST, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return array
     */
    public function patch(string $endpoint, array $data = []): array
    {
        return $this->request(Method::PATCH, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * 
     * @return array
     */
    public function delete(string $endpoint): array
    {
        return $this->request(Method::DELETE, $endpoint);
    }
    
    /**
     * @return void
     */
    public function generateNonce(): void
    {
        $this->nonce = uniqid();
    }
    
    /**
     * @param array $data
     * 
     * @return string
     */
    private function getSignature(array $data): string
    {
        // encode payload
        $payload = json_encode($data);
        
        // build signature
        $signature = '';
        
        openssl_sign(
            $payload,
            $signature,
            file_get_contents($this->privateKeyPath),
            OPENSSL_ALGO_SHA512
        );
        
        return base64_encode($signature);
    }
    
    /**
     * @return void
     */
    public function auth(): void
    {
        // generate nonce
        $this->generateNonce();
        
        // build data
        $data = [
            'login' => $this->username,
            'nonce' => $this->nonce,
            'lifetime' => 1800
        ];
        
        // build options
        $options = [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $this->getSignature($data),
            ],
            RequestOptions::JSON => $data,
        ];
        
        // make request
        $response = (new GuzzleCLient())->post($this->getUrl('/auth'), $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // decode json
        $tokenArray = json_decode($contents, true);
        
        // get expires
        $expires = (new DateTime())->setTimestamp(($tokenArray['expires'] - 10));
        
        // build token
        $this->token = new Token(
            $tokenArray['token'],
            $expires
        );
        
        // token update callback
        if ($this->tokenUpdateCallback !== null) {
            ($this->tokenUpdateCallback)($this->token);
        }
    }
    
    /**
     * @param Method $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * 
     * @return array
     */
    public function request(Method $method, string $endpoint, array $data = [], array $query = []): array
    {
        // check token
        if (
            $this->token == null
            or $this->token->isExpired()
        ) {
            $this->auth();
        }
        
        // build options
        $options = [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->token}",
            ],
            RequestOptions::JSON => $data,
            RequestOptions::QUERY => $query,
        ];
        
        // make request
        $response = (new GuzzleCLient())->request($method->value, $this->getUrl($endpoint), $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // decode json
        $json = json_decode($contents, true);
        
        return $json;
    }
}
