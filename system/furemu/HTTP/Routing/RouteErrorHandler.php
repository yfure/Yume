<?php

namespace Yume\Fure\HTTP\Routing;

/*
 * RouteErrorHandler
 *
 * @package Yume\Fure\HTTP\Routing
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