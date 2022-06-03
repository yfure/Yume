<?php

namespace Yume\Kama\Obi\Database;

use Yume\Kama\Obi\HTTP;

class Connection
{
    
    /*
     * ....
     *
     * @values Array
     */
    protected static $connections = [];
    
    public static function create( String $connect, Array $configs )//: Object
    {
        // Check if the database connection has not been established.
        if( !isset( self::$connections[$connect] ) )
        {
            // Create a new driver database connection.
            self::$connections[$connect] = new Driver( $configs );
        }
        return( self::$connections[$connect] );
    }
    
}

?>