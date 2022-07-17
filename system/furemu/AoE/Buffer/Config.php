<?php

namespace Yume\Kama\Obi\AoE\Buffer;

use Yume\Kama\Obi\Trouble;

/*
 * Config
 *
 * The actual Config properties are almost the same as Yume's
 * built-in config function, but usually each class has its own
 * configuration file, so this property will take the config
 * value based on the class name, namespace not included.
 *
 * @package Yume\Kama\Obi\AoE\Traits
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
            if( preg_match( "/\./", $key ) )
            {
                return( ify( $key, self::$configs ) );
            }
            if( isset( self::$configs[$key] ) )
            {
                return( self::$configs[$key] );
            }
            throw new Trouble\KeyError( $key );
        }
        return( self::$configs );
    }
    
}

?>