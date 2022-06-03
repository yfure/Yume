<?php

namespace Yume\Kama\Obi\Reflection;

use ReflectionFunction As Callback;

abstract class ReflectionFunction
{
    use Parameter;
    
    public static function reflect( String | Callable $funct ): Callback
    {
        return( new Callback( $funct ) );
    }
    
    public static function invoke( String | Callable $funct, ?Array $args = Null )
    {
        // Creating an instance of ReflectionFunction.
        $reflection = self::reflect( $funct );
        
        if( $args !== Null ) {
            
            // Get all parameters.
            // Check if function has parameter.
            if( count( $parameter = $reflection->getParameters() ) !== 0 ) {
                
                // Invoke function using parameter.
                //return( $reflection->invokeArgs( self::parameter( $parameter, $args ) ) );
                return( $reflection )->invokeArgs( $args );
            }
        }
        
        // Invoke function without parameter.
        return( $reflection->invoke() );
    }
}

?>