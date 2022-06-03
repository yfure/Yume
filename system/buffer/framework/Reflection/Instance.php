<?php

namespace Yume\Kama\Obi\Reflection;

use ReflectionClass;

use Yume\Kama\Obi\Exception;

class Instance
{
    use Parameter;
    
    public static function reflect( String | Object $class )
    {
        // Return ReflectionClass instance value.
        return new ReflectionClass( $class );
    }
    
    public static function construct( String | Object $class, Array $args = [] )
    {
        // Get ReflectionClass instance value.
        $reflect = self::reflect( $class );
        
        // Get all parameters.
        // Check if class has parameter.
        if( $reflect->getConstructor() !== Null ) {
            if( count( $parameter = $reflect->getConstructor()->getParameters() ) !== 0 ) {
                
                // Creating a new instance using parameters.
                //return( $reflect->newInstanceArgs( self::parameter( $parameter, $args ) ) );
                return( $reflect )->newInstanceArgs( $args );
                
            }
        }
        
        // Creating a new instance without parameters.
        return( $reflect->newInstance() );
    }
    
    public static function trait( Object | String $class )//: 
    {
        return( self::reflect( $class )->getTraits() );
    }
    
    public static function parent( Object | String $class ): Array | String | Null
    {
        // Get ReflectionClass instance value.
        $reflect = self::reflect( $class );
        
        // Check wheter if class have a parent.
        if( $reflect->getParentClass() !== False ) {
            
            // Parent class name.
            $name = $reflect->getParentClass()->name;
            
            // Check wheter if class have a parent.
            if( self::parent( $name ) !== Null ) {
                
                return([ $name => self::parent( $name )]);
            }
            return( $name );
        }
        return Null;
    }
    
    public static function interface( Object | String $class )//: 
    {
        return( array_keys( self::reflect( $class )->getInterfaces() ) );
    }
    
}

?>