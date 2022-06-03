<?php

namespace Yume\Kama\Obi\AoE;



use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Spl;

trait Config
{
    
    /*
     * In order not to call config too often.
     *
     * @access Protected, Static
     *
     * @values Array
     */
    protected static $config;
    
    /*
     * Fetching config by class name.
     * You can also retrieve config
     * values via @key parameter.
     *
     * @access Public, Static
     *
     * @params String, Null <key>
     *
     * @return Mixed
     */
    final public static function config( ? String $key = Null ): Mixed
    {
        if( self::$config === Null )
        {
            self::$config = config( Spl\Package\Package::className( __CLASS__ ) );
        }
        if( $key !== Null )
        {
            if( HTTP\Filter\RegExp::match( "/\./", $key ) )
            {
                return( Arrayable::ify( $key, self::$config ) );
            }
            if( isset( self::$config[$key] ) )
            {
                return( self::$config[$key] );
            }
            return( False );
        }
        return( self::$config );
    }
    
}

?>