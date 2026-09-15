.. _top:
.. title:: Bulk

`Back to index <index.rst>`_

====
Bulk
====

.. contents::
    :local:


Labels
``````

.. code-block:: php
    
    $ids = [
        12345,
        123456,
        1234567
    ];
    $result = $client->bulk->labels($ids, [
        
        // optional parameters
        'printer' => 'full',    // full or label
        'position' => 1,        // 1 (left top), 2 (right top), 3 (left bottom) or 4 (right bottom), only with printer format full
        'per_page' => 1,        // amount of stickers per page, only with printer format full, must be between 1 and 4, default 4
    ]);
    
    // store label in file
    $filename = '/path/to/label.pdf';
    $contents = base64_decode($result['attachment']);
    
    file_put_contents($filename, $contents);


Send orders
```````````

.. code-block:: php
    
    $ids = [
        12345,
        123456,
        1234567
    ];
    $result = $client->bulk->sendOrders($ids);


`Back to top <#top>`_