<?php

namespace Yume\Kama\Obi\Reflector;

use ReflectionClass;

/*
 * ReflectMethod
 *
 * @package Yume\Kama\Obi\Reflector
 */
abstract class ReflectMethod
{
    
    /*
     * @inherit 
     * @inherit 
     *
     */
    public static function invoke( Object | String $class, String $method, Array $args = [] ): Mixed
    {
        // Reflection class reference.
        $reflect = Null;
        
        // Create new instance class.
        $instance = ReflectClass::instance( $class, ref: $reflect );
        
        // Check if method has parameters.
        if( count( $parameter = $reflect->getMethod( $method )->getParameters() ) > 0 )
        {
            return( $reflect->getMethod( $method )->invokeArgs( $instance, ReflectParameter::bind( $parameter, $args ) ) );
        }
        return( $reflect->getMethod( $method )->invoke( $instance ) );
    }
    
}

?>