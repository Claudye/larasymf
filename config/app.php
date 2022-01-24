<?php

use Components\Http\Middleware\AdminRoleMiddleware;

return [
    "lang"=>'fr',
    "storage_path"=> __DIR__ .'/../assets/',

    /**
     * Function can call from
     */
    'function_controller' => joinPath('.','app','Pages'),

    /**
     * Translation
     */
    'translation'=> joinPath('.','app','lang'),
    "routes"=> joinPath('.','/routes'),
    
    'middleware'=>[
        'admin-role'=>AdminRoleMiddleware::class
    ]
];
