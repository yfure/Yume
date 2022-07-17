<?php

namespace Yume\Kama\Obi\HTTP\Routing;

/*
 * RouteErrorHandler
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
class RouteErrorHandler
{
    
    protected Array $groups = [
        
    ];
    
    protected String $method = None;
    
    public function __construct( protected Int $flags, protected Mixed $handler )
    {
        
    }
    
}

?>