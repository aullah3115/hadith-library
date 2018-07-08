<?php

return [
    // Connection protocol. It can be: http or bolt
    'protocol' => 'http',

    'host'     => env('NEO_HOST', 'localhost'),
    'port'     => env('NEO_PORT','7474'),
    'username' => env('NEO_USERNAME', 'neo4j'),
    'password' => env('NEO_PASSWORD', 'password'),
];
