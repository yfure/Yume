<?php

namespace Yume\Kama\Obi\Reflection;

use ReflectionMethod As Method;

abstract class ReflectionMethod
{
    use Parameter;
    
    public static function reflect( String | Object $class, String $method ): Method
    {
        return( new Method( $class, $method ) );
    }
    
    public static function invoke( String | Object $class, String $method, ?Array $args = Null )
    {
        // Creating an instance of ReflectionFunction.
        $r = self::reflect( $class, $method );
        
        if( is_string( $class ) ) {
            
            // Create new class instance.
            $class = Instance::construct( $class );
        }
        
        // Get all parameters.
        // Check if function has parameter.
        if( count( $parameter = $r->getParameters() ) !== 0 ) {
            
            // Invoke function using parameter.
            //return( $r->invokeArgs( $class, self::parameter( $parameter, $args ) ) );
            return( $r )->invokeArgs( $class, $args );
        }
        
        // Invoke function without parameter.
        return( $r->invoke( $class ) );
    }
    
}

?>