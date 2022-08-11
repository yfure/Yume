<?php

namespace Yume\Fure\Reflector;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;

use ReflectionIntersectionType;
use ReflectionType;
use ReflectionNamedType;
use ReflectionUnionType;
use Throwable;

/*
 * ReflectParameter
 *
 * @package Yume\Fure\Reflector
 */
abstract class ReflectParameter
{
    
    /*
     * Creating a function parameter binder.
     *
     * @access Public Static
     *
     * @params Array $params
     * @params Array $insert
     *
     * @return Array
     */
    final public static function bind( Array $params, Array $insert ): Array
    {
        $result = [];
        
        // Checks whether the given argument is a positional argument.
        if( RegExp\RegExp::test( "/^(?:(?<Index>[0-9]+))$/ms", implode( "", array_keys( $insert ) ) ) )
        {
            return( $insert );
        }
        
        foreach( $params As $param )
        {
            // Check if the parameter already has a value.
            if( isset( $insert[$param->name] ) )
            {
                $result[$param->name] = $insert[$param->name];
            } else {
                
                // Check if the parameter has type.
                if( $param->hasType() )
                {
                    // Check if parameter has default value.
                    if( $param->isDefaultValueAvailable() )
                    {
                        $result[$param->name] = $param->getDefaultValue();
                    } else {
                        
                        // Get parameters by type.
                        $result[$param->name] = self::retype( $retype = $param->getType() );
                        
                        // If the value is null and the parameter is not allowed use null.
                        if( $result[$param->name] === Null && $retype->allowsNull() === False )
                        {
                            // Remove parameter because this is not allows null value.
                            unset( $result[$param->name] );
                        }
                    }
                } else {
                    
                    // If parameter is allowed null.
                    if( $param->allowsNull() )
                    {
                        $result[$param->name] = Null;
                    }
                }
            }
        }
        
        return( $result );
    }
    
    /*
     * Get parameter values.
     *
     * @access Public Static
     *
     * @params ReflectionType $retype
     *
     * @return Object
     */
    final public static function retype( ReflectionType $retype ): ? Object
    {
        // Regular expression to check if the parameter has the class type declared.
        $regexp = f( "/^(?:((?<Package>{})\\\(?<Class>{})))$/i", RegExp\RegExp::replace( "/\\\/u", implode( "|", AoE\Package::$packages ), "\\\\\\\\" ), "[a-zA-Z_\x80-\xff][a-zA-Z0-9_\\\\x80-\xff]*[a-zA-Z0-9_\x80-\xff]" );
        
        // Get parameter type.
        $types = match( $retype::class )
        {
            // As of PHP 7.1.0
            ReflectionNamedType::class => explode( "|", $retype->getName() ),
            
            // As of PHP 8.0.0
            ReflectionUnionType::class,
            
            // As of PHP 8.1.0
            ReflectionIntersectionType::class => $retype->getTypes()
        };
        
        foreach( $types As $type )
        {
            // Check if the type parameter is a class.
            if( RegExp\RegExp::test( $regexp, $type ) )
            {
                // Return class instance value.
                return( ReflectClass::instance( $type ) );
            }
        }
        
        return( Null );
    }
    
}

?>