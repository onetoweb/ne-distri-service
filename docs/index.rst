.. title:: Index

Index
=====

.. contents::
    :local:

===========
Basic Usage
===========

Setup

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\NeDistriService\{Client, Token};
    use Symfony\Component\HttpFoundation\Session\Session;
    
    // start session
    $session = new Session();
    $session->start();
    
    // param
    $username = 'info@example.com';
    $privateKeyPath = '/path/to/privkey.pem';
    
    // setup client
    $client = new Client($username, $privateKeyPath);
    
    // set token update callback
    $client->setTokenUpdateCallback(function(Token $token) use ($session) {
        
        // store token
        $session->set('token', [
            'value' => $token->getValue(),
            'expires' => $token->getExpires(),
        ]);
    });
    
    // load token from storage
    if ($session->has('token')) {
        
        $tokenArray = $session->get('token');
        
        // build token
        $token = new Token(
            $tokenArray['value'],
            $tokenArray['expires']
        );
        
        // set token
        $client->setToken($token);
    }


========
Examples
========

* `General <general.rst>`_
