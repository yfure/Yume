<?php

namespace Yume\Util\Database;

use Yume\Util\Himei;
use Yume\Util\Reflection;
use Yume\Util\Trouble;

/*
 * Database utility class.
 *
 * @package Yume\Util\Database
 */
abstract class Database
{
    
    /*
     * Save the entire database connections.
     *
     * @access Protected, Static
     *
     * @values Array
     */
    protected static $connections = [];
    
    use \Yume\Util\Himei\Config;
    
    /*
     * Create new, database connection.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return Object
     */
    final public static function connect( String $name )
    {
        
        // If connection is created.
        if( isset( self::$connections[$name] ) )
        {
            return( self::$connections[$name] );
        }
        
        // If connection is exists.
        if( $config = self::config( "connections.{$name}" ) )
        {
            
            // Connection driver.
            $connectDriverName = $config['driver'];
            
            /*
             * If connection driver have options.
             *
             * But if driver is string value then by default it
             * will take configuration value from default driver.
             */
            if( is_array( $connectDriverName ) )
            {
                $connectDriverName = $config['driver']['name'];
            } else {
                $config['driver'] = self::config( "drivers" )[self::config( "driver" )];
            }
            
            // If driver name is default.
            if( $connectDriverName === "default" )
            {
                $connectDriverName = self::config( "driver" );
            }
            
            // Select database driver.
            return( self::$connections[$name] = match( $connectDriverName )
            {
                
                // PHP Data Object Driver.
                "PDO" => call_user_func( function() use( $name, $config )
                {
                    
                    // Database driver prefix.
                    $driver = Driver\PDO\PDO::class;
                    
                    // Database server name.
                    $driver .= $config['database']['server'];
                    
                    // New PDO Instance.
                    return( Reflection\ReflectionInstance::construct( $driver, [ $name, $config ] ) );
                    
                }),
                
                // PHP MongoDB Driver.
                "MongoDB" => new Driver\Mongo\MongoProvider( $config ),
                
                // No matching driver.
                default => throw new Trouble\Exception\DatabaseDriverError( "No database driver matching {$connectDriverName}" )
                
            });
            
        } else {
            throw new Trouble\Exception\DatabaseError( "Undefined database connection {$name}" );
        }
        
    }
    
    final public static function disconnect( String $name ): Void
    {
        unset( self::$connections[$name] );
    }
    
}

?>
