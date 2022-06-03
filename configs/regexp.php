<?php

/*
 * Config to save various patterns.
 *
 * @author hxAri
 * @licence Under MIT
 *
 * @handler Yume\Kama\Obi\HTTP\Filter\RegExp
 */
return [
    'patterns' => [
        
        // Regex pattern for username.
        'username' => "/([a-z_][a-z0-9_.]+[a-z0-9_]*)/",
        
        // Regex pattern for Email Address.
        'usermail' => "/^([a-z][a-z0-9.]+[a-z0-9])\@([a-z][a-z0-9]{0,30})\.([a-z]{0,10})$/",
        
        // Regex pattern for route validation.
        'routing' => [
            'default' => "/([a-zA-Z0-9\-\_]+)/",
            'replace' => "/\:([a-zA-Z0-9\-\_]+)/",
            'params' => "/\:([a-zA-Z0-9\-\_]+)|\(.*?\)/"
        ]
    ]
];

?>