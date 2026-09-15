.. _top:
.. title:: Webhook

`Back to index <index.rst>`_

=======
Webhook
=======

.. contents::
    :local:


Example fetching and validating data using the webhook utils
````````````````````````````````````````````````````````````

.. code-block:: php
    
    use Symfony\Component\HttpFoundation\Response;
    use Onetoweb\NeDistriService\Util\Webhook;
    
    // verify webhook data
    if (Webhook::validate()) {
    
        // get webhook data
        $data = Webhook::data();
        
        // send ok response
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->send();
        
    } else {
        
        // send bad request response
        $response = new Response();
        $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        $response->send();
    }


`Back to top <#top>`_