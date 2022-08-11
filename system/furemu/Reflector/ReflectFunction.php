<?php

namespace Yume\Fure\Reflector;

use ReflectionFunction;
use Closure;

/*
 * ReflectFuction
 *
 * @package Yume\Fure\Reflector
 */
abstract class ReflectFunction
{
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionfunction.invoke.php
     * @inherit https://www.php.net/manual/en/reflectionfunction.invokeargs.php
     *
     */
    final public static function invoke( Closure | String $function, Array $args = [] ): Mixed
    {
        // Get function reflection.
        $reflect = new ReflectionFunction( $function );
        
        // Get function parameters.
        $params = $reflect->getParameters();
        
        // Check if function has parameters.
        if( count( $params ) > 0 )
        {
            return( $reflect )->invokeArgs( ReflectParameter::bind( $params, $args ) );
        }
        
        // Reflection function without arguments.
        return( $reflect->invoke() );
    }
    
}

?>