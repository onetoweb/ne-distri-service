.. _top:
.. title:: Shipment

`Back to index <index.rst>`_

========
Shipment
========

.. contents::
    :local:


List Shipments
``````````````

.. code-block:: php
    
    $result = $client->shipment->list([
        
        // optional parameters
        'page' => 1,
        'search' => '123456',
        'order_type' => '1',
        'modified_from' => 1789459498,
        'modified_to' => 1789459498,
    ]);


Get Shipment
````````````

.. code-block:: php
    
    $result = $client->shipment->get([
        
        // either ordernumber and shipmentnumber or order_id must be set
        'ordernumber' => 123456,
        'shipmentnumber' => 123456,
        'order_id' => 123456,
    ]);


`Back to top <#top>`_