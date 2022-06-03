<?php

namespace Yume\Kama\Obi\Database\Traits;

trait Config
{
    
    use \Yume\Kama\Obi\AoE\Config;
    
    public static function default()
    {
        return( self::config( "connection" ) );
    }
    
    public static function connection( ?String $connection = Null )
    {
        if( $connection === Null ) {
            $connection = self::default();
        }
        return( self::config( "connections.{$connection}" ) );
    }
    
}

?>