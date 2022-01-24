<?php

return [
    'default'=>'mysql',
    'sqlite'=> [
        'database'=>__DIR__ .'/../database/database.db',
        'driver'=>'sqlite'
    ],
    "mysql" =>[
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'laraymsf',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ]
    
];