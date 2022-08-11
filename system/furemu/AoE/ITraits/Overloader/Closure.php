<?php

namespace Yume\Fure\AoE\ITraits\Overloader;

use Yume\Fure\Error;

/*
 * Closure
 *
 * @package Yume\Fure\AoE\ITraits\Overloader
 */
trait Closure
{
    use Overload;
    
    /*
     * Triggered when invoking inaccessible methods in an object context.
     *
     * @access Public
     *
     * @params String $name
     * @params Array $args
     *
     * @return Mixed
     */
    public function __call( String $name, Array $args ): Mixed
    {
        // Check if property exists.
        if( property_exists( $this, $name ) )
        {
            // Check if property is callable.
            if( is_callable( $this->{ $name } ) === False )
            {
                throw new MethodError( [ $name, __CLASS__ ], MethodError::UNCALLABLE );
            }
            return( call_user_func_array( $this->{ $name }, $args ) );
        }
        
        // Check if data overload is array.
        if( is_array( $this->data ) )
        {
            // Check if data is exists.
            if( isset( $this->data[$name] ) )
            {
                // Check if data is callable.
                if( is_callable( $this->data[$name] ) === False )
                {
                    throw new MethodError( [ $name, __CLASS__ ], MethodError::UNCALLABLE );
                }
                return( call_user_func_array( $this->data[$name], $args ) );
            }
        }
        throw new Error\MethodError( [ $name, __CLASS__ ], MethodError::UNDEFINED );
    }
    
    /*
     * Triggered when invoking inaccessible methods in a static context.
     *
     * @access Public Static
     *
     * @params String $name
     * @params Array $args
     *
     * @return Mixed
     */
    public static function __callStatic( String $name, Array $args ): Mixed
    {
        // Check if property exists.
        if( property_exists( __CLASS__, $name ) )
        {
            return( call_user_func_array( self::${ $name }, $args ) );
        }
        throw new Error\MethodError( [ $name, __CLASS__ ], MethodError::UNDEFINED );
    }
    
}

?>