<?php

namespace Yume\Kama\Obi\HTTP\Route;

trait RouteDefinition
{
    
    public static function add( Array | String $method, String $path, Array | String | Callable $handler, ? Callable $group = Null ): Route
    {
        self::$routes[] = new Route([
            'path' => $path,
            'group' => $group,
            'method' => $method,
            'handler' => $handler
        ]);
        return( end( self::$routes ) );
    }
    
}

?>