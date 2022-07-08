<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Services;

/*
 * RouteServices
 *
 * @extends Yume\Kama\Obi\Services\Services
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
final class RouteServices extends Services\Services
{
    
    /*
     * @inherit Yume\Kama\Obi\Services\ServicesInterface
     *
     */
    public static function boot(): Void
    {
        // Register regular expression segment in here.
        $segments = [
            
            // For default you can replace it in the app configuration file.
            "default" => AoE\App::config( "http.routing.regexp.default" ),
            
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