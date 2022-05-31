<?php

namespace Yume\Util\Database;

use function Yume\Func\config;

use Yume\Util\Himei;
use Yume\Util\Reflection;
use Yume\Util\Trouble;

/*
 * Database Connection utility class.
 *
 * @package Yume\Util\Database
 */
abstract class Connection extends Database
{
    
    /*
     * Save the entire database connections.
     *
     * @access Protected, Static
     *
     * @values Yume\Util\Himei\Data
     */
    protected static $connections;
    
    /*
     * Create new database connection.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return Object
     */
    public static function create( String $name ): Object
    {
        if( self::$connections Instanceof Himei\Data === False )
        {
            self::$connections = new Himei\Data;
        }
        if( self::exists( $name ) === False )
        {
            self::$connections[$name] = self::select( parent::config( "connections.{$name}" ) );
        }
        return( self::$connections[$name] );
    }
    
    /*
     * Check if database connection exists.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return Bool
     */
    public static function exists( String $name ): Bool
    {
        return( self::$connections->offsetExists( $name ) );
    }
    
    /*
     * Select database driver.
     *
     * @access Private, Static
     *
     * @params Yume\Util\Himei\Data <config>
     *
     * @return Object
     */
    private static function select( Himei\Data $config ): Object
    {
        /** Get Database driver name. */
        $driverName = $config->database->driver->name;
        
        /*
         * Default driver preferences.
         *
         * @see /configs/database[driver]
         */
        if( $driverName === "default" || $driverName === "PDO" )
        {
            if( extension_loaded( "PDO" ) )
            {
                // Database driver parent.
                $driver = Driver\PHPDataObject::class;
                
                // ....
                $driver .= $config->database->server;
                
                return( Reflection\ReflectionInstance::construct( $driver, [ $config ] ) );
            }
            throw new Trouble\Exception\ModuleError( "PDO extension not installed." );
        } else {
            if( $driverName === "MongoDB" )
            {
                    throw new Trouble\Exception\DatabaseDriverError( "Oops! Sorry, the MongoDB driver is currently under development." );
            }
            throw new Trouble\Exception\DatabaseDriverError( "Database driver is not supported for {$config['database']['server']}." );
        }
    }
    
}

?>
