.. _top:
.. title:: Order

`Back to index <index.rst>`_

=====
Order
=====

.. contents::
    :local:


List Orders
```````````

.. code-block:: php
    
    $result = $client->order->list([
        
        // optional parameters
        'page' => 1,
        'reference' => '123456',
        
    ]);


Get Order
`````````

.. code-block:: php
    
    $id = 123456;
    $result = $client->order->get($id);


Create order
````````````

.. code-block:: php
    
    $data = [
        'address' => [
            'address' => 'Destination 123',
            'country' => 'NL',
            'email' => 'ad@friet.pan',
            'name' => 'Ad Patat',
            'phone' => 31640302010,
            'place' => 'AMSTERHAAG',
            'zipcode' => '1234AB'
        ],
        'load_date' => 1643842800,
        'load_remarks' => '',
        'order_type' => 5,
        'reference' => [
            'ref1',
            'ref2',
            'ref3'
        ],
        'remarks' => '',
        'rules' => [
            [
                'amount' => 2,
                'barcodes' => [
                    [
                        'coli_number' => 1,
                        'barcode' => '200099000300001'
                    ], [
                        'coli_number' => 2,
                        'barcode' => '200099000300002'
                    ]
                ],
                'description' => 'Two curtains',
                'unit' => 'HAN',
                'weight' => 20
            ]
        ],
        'sender' => [
            'address' => 'Origin 123',
            'country' => 'NL',
            'email' => 'ad@friet.pan',
            'name' => 'Ad Patat',
            'phone' => 31640302010,
            'place' => 'AMSTERHAAG',
            'zipcode' => '1234AB'
        ],
        'unload_date' => 1643929200,
        'unload_remarks' => '',
        'user_code' => 1337
    ];
    $result = $client->order->create($data);


Delete order
````````````

.. code-block:: php
    
    $id = 123456;
    $result = $client->order->delete($id);


Update order
````````````

.. code-block:: php
    
    $id = 123456;
    $data = [
        'remarks' => 'Changed remarks text'
    ];
    $result = $client->order->update($id, $data);


Send order
``````````

.. code-block:: php
    
    $id = 123456;
    $result = $client->order->send($id);


Barcode Stickers
````````````````

.. code-block:: php
    
    $id = 123456;
    $result = $client->order->label($id, [
        
        // optional parameters
        'printer' => 'full',    // full or label
        'position' => 1,        // 1 (left top), 2 (right top), 3 (left bottom) or 4 (right bottom), only with printer format full
        'per_page' => 1,        // amount of stickers per page, only with printer format full, must be between 1 and 4, default 4
    ]);


`Back to top <#top>`_