<?php

namespace Yume\Kama\Obi\Database\Driver;

use Yume\Kama\Obi\AoE;

/*
 * Data Source Name utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver
 */
abstract class PHPDataObjectDSN
{
    
    /*
     * Create new Data Source Name by database.
     *
     * @access Public, Static
     *
     * @params Yume\Kama\Obi\Hime\Data <config>
     *
     * @return String
     */
    final public static function create( String $server, AoE\Data $config ): String
    {
        return( self::{ $server }( $config ) );
    }
    
    final public static function mysql( AoE\Data $config ): String
    {
        
        // The Database socket.
        $sock = $config->database['socket'];
        
        // The Database credentials.
        $host = $config->database->private->hostname;
        $port = $config->database->private->portname;
        $name = $config->database->private->database;
        
        // The DSN prefix for mysql.
        $dsn = "mysql:dbname=$name;";
        
        if( $sock !== Null )
        {
            $dsn .= "unix_socket=$sock;";
        } else {
            $dsn .= "host=$host;";
            $dsn .= "port=$port;";
        }
        return( $dsn );
    }
    
}

?>