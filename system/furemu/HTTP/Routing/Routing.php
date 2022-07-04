<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\AoE;

abstract class Routing
{
    
    final public static function define(): Void
    {
        
        
        
        // .....
        AoE\Package::import( AoE\App::config( "http.routing.routes" ) );
        
    }
    
}

?>