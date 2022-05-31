<?php

namespace Yume\Util\Database\Driver\PDO;

use Yume\Util\Himei;

/*
 * Data Source Name utility class.
 *
 * @package Yume\Util\Database\Driver\PDO
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
