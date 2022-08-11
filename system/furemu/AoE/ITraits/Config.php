<?php

namespace Yume\Fure\AoE\ITraits;

use Yume\Fure\Error;
use Yume\Fure\RegExp;

/*
 * Config
 *
 * The actual Config properties are almost the same as Yume's
 * built-in config function, but usually each class has its own
 * configuration file, so this property will take the config
 * value based on the class name, namespace not included.
 *
 * @package Yume\Fure\AoE\Traits
 */
trait Config
{
    
    use Package;
    
    /*
     * Save the values from the configuration file.
     *
     * @values Array
     */
    protected static $configs;
    
    protected static $cached = [];
    
    /*
     * Retrieve the configuration value.
     *
     * @access Public Static
     *
     * @params String $key
     *
     * @return Mixed
     */
    public static function config( ? String $key = Null ): Mixed
    {
        if( self::$configs === Null )
        {
            self::$configs = config( strtoupper( self::name() ) );
        }
        if( $key !== Null )
        {
            if( isset( self::$cached[$key] ) )
            {
                return( self::$cached[$key] );
            }
            if( RegExp\RegExp::test( "/\./", $key ) )
            {
                return( self::$cached[$key] = envable( ify( $key, self::$configs ) ) );
            }
            if( isset( self::$configs[$key] ) )
            {
                return( self::$cached[$key] = envable( self::$configs[$key] ) );
            }
            throw new Error\KeyError( $key );
        }
        return( self::$configs );
    }
    
}

?>