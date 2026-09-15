.. _top:
.. title:: Schedule

`Back to index <index.rst>`_

========
Schedule
========

.. contents::
    :local:


List Schedule
`````````````

.. code-block:: php
    
    $result = $client->schedule->list([
        'order_type' => 5,
        'zipcode' => '1111AA',
        'country' => 'NL',
        
        // optional parameters
        'user_code' => 42,
        'start' => 1789462100,
    ]);


`Back to top <#top>`_