<?php

use Yume\Kama\Obi\HTTP\Route;

return [
    
    /*
     * Routes file name.
     *
     * You can change it if you don't like the filename.
     */
    'filename' => "/system/routes/routes",
    
    /*
     * Default controller method name.
     * You can also include controller method names in parameters.
     */
    'callback' => "main",
    
    /*
     * Built-in function to handle route when error.
     */
    'handling' => function( Route\RouteError $error ) {
        
    }
    
];

?>