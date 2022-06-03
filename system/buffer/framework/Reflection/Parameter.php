<?php

namespace Yume\Kama\Obi\Reflection;

use Yume\Kama\Obi\HTTP;

/*
 * This trait is having a bug!
 *
 */
trait Parameter
{
    
    public static function declare( String $type ): Bool
    {
        return( HTTP\Filter\RegExp::match( "/(?<!\\w)(array|arrayaccess|backedenum|bool|callable|class|closure|fiber|float|generator|int|integer|iterator|iteratoraggregate|string|object|iterable|mixed|self|serializable|stringable|parent|throwable|traversable|unitenum|weakmap|weakreference)/i", $type ) );
    }
    
    public static function argument( String $argType, Mixed $value ): Mixed
    {
        
        // Get value type.
        $valType = gettype( $value );
        
        if( $argType !== $valType ) {
            if( HTTP\Filter\RegExp::match( "/\|/", $argType ) ) {
                
                $types = explode( "|", $argType );
                
                foreach( $types As $type ) {
                    if( $valType === $type ) {
                        return $value;
                    } else
                    if( HTTP\Filter\RegExp::match( "/\\\/", $type ) ) {
                        return new $type;
                    }
                }
            } else
            if( HTTP\Filter\RegExp::match( "/\\\/", $argType ) ) {
                return new $argType;
            }
        }
        return $value;
    }
    
    public static function parameter( Array $params, ?Array $values ): Array
    {
        if( $values !== Null ) {
            foreach( $params As $i => $arg ) {
                
                // Check if the parameter has a special type.
                // Check if type parameter is php default declaration.
                if( $arg->hasType() ) {
                    if( self::declare( $argType = $arg->getType()->__toString() ) ) {
                        
                        // Check if the value of type is object.
                        if( gettype( $values[$i] ) === "object" ) {
                            
                            // Match the class name.
                            if( $values[$i]::class === $argType ) {
                                continue;
                            }
                            
                            // Equalize class parent name.
                            if( get_parent_class( $values[$i] ) === $argType ) {
                                continue;
                            }
                        } else {
                            $value = self::argument( $argType, $values[$i] );
                        }
                    } else {
                        $value = self::argument( $argType, $values[$i] );
                    }
                    // Argument from module type name.
                    array_splice( $values, $i, 0, array( $value ) );
                }
            }
            array_pop( $values );
            return $values;
        }
        return [];
    }
}

?>