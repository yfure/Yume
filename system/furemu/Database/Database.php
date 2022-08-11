<?php

namespace Yume\Fure\Database;

use Yume\Fure\AoE;
use Yume\Fure\Environment;
use Yume\Fure\Error;
use Yume\Fure\Reflector;
use Yume\Fure\Threader;

/*
 * Database
 *
 * Database connection.
 *
 * @package Yume\Fure\Database
 */
abstract class Database implements AoE\Intafesu\Unchangeable
{
    use AoE\ITraits\Config;
    
    /*
     * Create new database connection.
     *
     * @access Public Static
     *
     * @params String $name
     *
     * @return Yume\Fure\Database\DatabaseDriverInterface
     */
    public static function connect( ? String $name = Null ): DatabaseDriverInterface
    {
        // If database connection name is null.
        if( $name === Null )
        {
            // Use default database connection.
            $name = Threader\App::config( "database.default.connection" );
        }
        
        // If the configuration does not exist.
        if( self::$configs Instanceof AoE\Data === False )
        {
            self::$configs = new AoE\Data( Environment\Environment::mapping( Threader\App::config( "database" ) ) );
        }
        
        // Check if the connection name is available.
        if( self::$configs->connections->__isset( $name ) )
        {
            // Copy connection configuration.
            $object = self::$configs->connections->{ $name };
            
            // Check if the connection does not have a driver.
            if( $object->__isset( "driver" ) === False )
            {
                // Use the default driver.
                $object->driver = self::$configs->default->driver;
            }
            
            // Create new driver instance.
            return( self::create( $name, $object ) );
        } else {
            throw new DatabaseError( $name, DatabaseError::CONNECTION_ERROR );
        }
    }
    
    /*
     * Create new database driver instance.
     *
     * @access Private Static
     *
     * @params String $name
     * @params Yume\Fure\AoE\Data
     *
     * @return Yume\Fure\Database\DatabaseDriverInterface
     */
    private static function create( String $name, AoE\Data $object ): DatabaseDriverInterface
    {
        // Check if the driver is available.
        if( self::$configs->drivers->__isset( $object->driver ) )
        {
            // Get database driver configuration.
            $driver = self::$configs->drivers->{ $object->driver };
            
            // Return class instance from driver.
            return( Reflector\ReflectClass::instance( $driver->class, [ $name, $driver, $object ] ) );
        } else {
            throw new DatabaseError( [ $object->driver, $name ], DatabaseError::DRIVER_ERROR );
        }
    }
    
}

?>