<?php

namespace Yume\Fure\HTTP\Routing;

use Yume\Fure\AoE;
use Yume\Fure\Services;
use Yume\Fure\Threader;

/*
 * RouteServices
 *
 * @extends Yume\Fure\Services\Services
 *
 * @package Yume\Fure\HTTP\Routing
 */
final class RouteServices extends Services\Services
{
    
    /*
     * @inherit Yume\Fure\Services\ServicesInterface
     *
     */
    public static function boot(): Void
    {
        // Register regular expression segment in here.
        $segments = [
            
            // For default you can replace it in the app configuration file.
            "default" => Threader\App::config( "http.routing.regexp.default" ),
            
            // Todo code here...
            "user" => "[a-zA-Z_\x80-\xff][a-zA-Z0-9_\.\x80-\xff][a-zA-Z0-9_\x80-\xff]*"
            
        ];
        
        // Mapping segments.
        array_map( array: $segments, callback: function( $regexp ) use( $segments )
        {
            // Statically variable.
            static $i = 0;
            
            // Register segment.
            RouteSegment::set( array_keys( $segments )[$i++], $regexp );
        });
    }
    
}

?>