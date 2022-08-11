<?php

namespace Yume\Fure\Database\Driver\PDO;

use Yume\Fure\AoE;

use UnhandledMatchError;

/*
 * PDOBuilder
 *
 * @package Yume\Fure\Database\Driver\PDO
 */
abstract class PDOBuilder
{
    
    /*
     * PHP Data Object Data Source Name Builder.
     *
     * @access Public Static
     *
     * @params Yume\Fure\AoE\Data
     *
     * @return String
     */
    public static function dsn( AoE\Data $configs ): String
    {
        try {
            return( match( $configs->server )
            {
                "MySQL",
                "MySQLi" => self::mysql( $configs ),
                
                "OCI",
                "Oracle" => self::oracle( $configs ),
                
                "PgSQL",
                "Postgre" => self::pqsql( $configs ),
                
                "SQLite" => self::sqlite( $configs )
            });
        }
        catch( UnhandledMatchError $e )
        {
            throw new DatabaseError( $configs->server, DatabaseError::SERVER_ERROR, $e );
        }
    }
    
    /*
     * PHP Data Source Name for MySQL.
     *
     * @access Protected Static
     *
     * @params Yume\Fure\AoE\Data
     *
     * @return String
     */
    protected static function mysql( AoE\Data $configs ): String
    {
        // Check if the database has a socket.
        if( $configs->__isset( "socket" ) )
        {
            // Only use socket without host and port.
            return( f( "mysql:unix_socket={0};dbname={1}", [
                $configs->socket,
                $configs->connect->{ "database.name" }
            ]));
        }
        return( f( "mysql:host={ database.host };port={ database.port };dbname={ database.name }", $configs->connect ) );
    }
    
    /*
     * PHP Data Source Name for Oracle.
     *
     * @access Protected Static
     *
     * @params Yume\Fure\AoE\Data
     *
     * @return String
     */
    protected static function oracle( AoE\Data $configs ): String
    {
        // Check if the database has a host.
        if( $configs->connect->__isset( "database.host" ) === False )
        {
            // Connect to a database defined in tnsnames.ora
            $dsn = "oci:dbname={ database.name }";
        } else {
            
            // Connect using the Oracle Instant Client.
            $dsn = "oci:dbname=//{ database.host }:{ database.port }/{ database.name }";
        }
        return( f( $dsn, $configs->connect ) );
    }
    
    /*
     * PHP Data Source Name for PgSQL.
     *
     * @access Protected Static
     *
     * @params Yume\Fure\AoE\Data
     *
     * @return String
     */
    protected static function pqsql( AoE\Data $configs ): String
    {
        return( f( "pgsql:host={ database.host };port={ database.port };dbname={ database.name };user={ database.user };password={ database.pass }", $configs->connect ) );
    }
    
    /*
     * PHP Data Source Name for SQLite.
     *
     * @access Protected Static
     *
     * @params Yume\Fure\AoE\Data
     *
     * @return String
     */
    protected static function sqlite( AoE\Data $configs ): String
    {
        return( f( "sqlite:{ database.path }", $configs->connect ) );
    }
    
}

?>