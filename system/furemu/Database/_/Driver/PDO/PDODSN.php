<?php

namespace Yume\Kama\Obi\Database\Driver\PDO;

use Yume\Kama\Obi\Himei;

/*
 * Data Source Name utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver\PDO
 */
abstract class PDODSN
{
    
    /*
     * PDO MySQL Data Source Name.
     *
     * @access Public, Static
     *
     * @params Array <config>
     *
     * @return String
     */
    final public static function MySQL( Array $config ): String
    {
        
        // The Database socket.
        $sock = isset( $config['socket'] ) ? $config['socket'] : Null;
        
        // The Database credentials.
        $host = $config['database']['private']['hostname'];
        $port = $config['database']['private']['portname'];
        $name = $config['database']['private']['database'];
        
        // The DSN prefix for mysql.
        $dsn = "mysql:";
        
        if( $name !== Null )
        {
            $dsn .= "dbname=$name;";
        }
        
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