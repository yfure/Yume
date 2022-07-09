<?php

namespace Yume\Kama\Obi\Reflector;

use ReflectionFunction;
use Closure;

/*
 * ReflectFuction
 *
 * @package Yume\Kama\Obi\Reflector
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
            return( $reflect )->invokeArgs( $args );
        }
        
        // Reflection function without arguments.
        return( $reflect->invoke() );
    }
    
}

?>