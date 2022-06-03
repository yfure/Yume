<?php

namespace Yume\Kama\Obi\Spl;

class Autoload
{
    public static function functions()
    {
        return spl_autoload_functions();
    }
    
    public static function extension( String $extension )
    {
        return spl_autoload_extensions( $extension );
    }
    
    public static function autoload()
    {
        
    }
    
    public static function register( Array | String | Object | Callable $callback, Bool $throw = True, Bool $prepend = False ): Bool
    {
        return spl_autoload_register( $callback, $throw, $prepend );
    }
}

?>