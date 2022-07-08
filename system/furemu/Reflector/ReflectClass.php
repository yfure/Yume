<?php

namespace Yume\Kama\Obi\Reflector;

use Yume\Kama\Obi\AoE;

use ReflectionClass;

/*
 * Kurasu
 *
 * The Kurasu class reports information about a class.
 *
 * @package Yume\Kama\Obi\Reflector
 */
abstract class ReflectClass
{
    
    /*
     * Gets new reflection.
     *
     * @params Object String class
     *
     * @return ReflectionClass as Instance.
     */
    final public static function reflect( Object | String $class ): ReflectionClass
    {
        if( is_object( $class ) )
        {
            if( $class Instanceof ReflectionClass )
            {
                return( $class );
            }
        }
        return( new ReflectionClass( $class ) );
    }
    
    /*
     * Create new class contructor.
     *
     * @access Public Static
     *
     * @params String, Object class
     * @params Array args
     *
     * @return Object
     */
    final public static function construct( String | Object $class, Array $args = [] ): Object
    {
        // New Reflection.
        $reflect = self::reflect( $class );
        
        if( $reflect->getConstructor() !== Null )
        {
            if( count( $parameter = $reflect->getConstructor()->getParameters() ) !== 0 )
            {
                return( $reflect )->newInstanceArgs( $args );
            }
        }
        return( $reflect->newInstance() );
    }
    
    final public static function getConstants( Object | String $class, Bool $onlyName = False ): Array
    {
        return( self::reflect( $class ) )->getConstants();
    }
    
    /*
     * Gets the interfaces.
     *
     * @access Public Static
     *
     * @params Object, String $class
     * @params Bool $onlyName
     *
     * @return Array
     */
    final public static function getInterfaces( Object | String $class, Bool $onlyName = False ): Array
    {
        if( $onlyName )
        {
            return( self::reflect( $class ) )->getInterfaceNames();
        }
        return( self::reflect( $class ) )->getInterfaces();
    }
    
    /*
     * Gets an array of methods.
     *
     * @access Public Static
     *
     * @params Object, String $class
     * @params Int $filter
     *
     */
    final public static function getMethods( Object | String $class, Bool $onlyName = False, Int $filter = 0 )
    {
        
        // Get all methods by filter.
        $methods = self::reflect( $class )->getMethods( $filter !== 0 ? $filter : AoE\App::config( "reflector.instance.method.filter" ) );
        
        if( $onlyName )
        {
            foreach( $methods As $i => $method )
            {
                $methods[$i] = $method->name;
            }
        }
        
        return( $methods );
    }
    
    /*
     * Get parent class reflection.
     *
     * @access Public Static
     *
     * @params Object, String $class
     *
     * @return Object
     */
    final public static function getParent( Object | String $class ): ? ReflectionClass
    {
        return( self::reflect( $class ) )->getParentClass();
    }
    
    /*
     * Get the parent class name to the bottom of the order.
     *
     * @access Public Static
     *
     * @params Object, String $class
     *
     * @return Array, String
     */
    final public static function getParentTree( Object | String $class ): Array | String | Null
    {
        
        $parent = self::reflect( $class )->getParentClass();
        
        if( $parent !== False )
        {
            if( self::getParentTree( $parent = $parent->name ) !== Null )
            {
                return([ $parent => self::getParentTree( $parent ) ]);
            }
            return( $parent );
        }
        
        return Null;
    }
    
    final public static function getProperties( Object | String $class )
    {
        // ....
    }
    
    /*
     * Returns an array of traits used by this class.
     *
     * @access Public Static
     *
     * @params Object, String $class
     *
     * @return Array
     */
    final public static function getTraits( Object | String $class )
    {
        return( self::reflect( $class ) )->getTraits();
    }
    
    /*
     * Checks if in namespace.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function inNamespace( Object | String $class ): Bool;
    
    /*
     * Checks if class is abstract.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isAbstract( Object | String $class ): Bool;
    
    /*
     * Checks if class is anonymous.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isAnonymous( Object | String $class ): Bool;
    
    /*
     * Returns whether this class is cloneable.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isCloneable( Object | String $class ): Bool;
    
    /*
     * Check if class is countable.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isCountable( Object | String $class ): Bool;
    
    /*
     * Check if class is data.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isData( Object | String $class ): Bool;
    
    /*
     * Returns whether this is an enum.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isEnum( Object | String $class ): Bool;
    
    /*
     * Checks if class is final.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isFinal( Object | String $class ): Bool;
    
    abstract public static function isInstance( Object $object ): Bool;
    
    /*
     * Checks if class is instantiable.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isInstantiable( Object | String $class ): Bool;
    
    /*
     * Checks if class is interface.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isInterface( Object | String $class ): Bool;
    
    /*
     * Checks if class is defined internally by an extension, or the core.
     *
     * @access Public Static
     *
     * @params Object, String class>
     *
     * @return Bool
     */
    abstract public static function isInternal( Object | String $class ): Bool;
    
    /*
     * Checks if class is iterable.
     *
     * @access Public Static
     *
     * @params Object, String class>
     *
     * @return Bool
     */
    abstract public static function isIterable( Object | String $class ): Bool;
    
    /*
     * Checks if class is stringable.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isStringable( Object | String $class ): Bool;
    
    /*
     * Checks if a subclass.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isSubclassOf( Instance | string $class ): Bool;
    
    /*
     * Returns whether this is a trait.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isTrait( Object | String $class ): Bool;
    
    /*
     * Checks if user defined.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    abstract public static function isUserDefined( Object | String $class ): Bool;
    
    /*
     * Parse object or class to string.
     *
     * @access Public Static
     *
     * @params Object, String class
     *
     * @return Bool
     */
    final public static function toString( Object | String $class ): String
    {
    }
    
}

?>