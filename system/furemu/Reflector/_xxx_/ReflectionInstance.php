<?php

namespace Yume\Kama\Obi\Reflection;

use Yume\Kama\Obi\Himei;

use ReflectionClass As Instance;

abstract class ReflectionInstance extends ReflectionProvider implements ReflectionInterface
{
    
    /*
     * Gets new reflection.
     *
     * @params Object, String <class>
     *
     * @return ReflectionClass as Instance.
     */
    final public static function reflect( Object | String $class ): Instance
    {
        if( is_object( $class ) )
        {
            if( $class Instanceof Instance )
            {
                return( $class );
            }
        }
        return( new Instance( $class ) );
    }
    
    /*
     * Create new class contructor.
     *
     * @access Public, Static
     *
     * @params String, Object <class>
     * @params Array <args>
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
    
    final public static function getConstants( Object | String $class ): Array
    {
        return( self::reflect( $class ) )->getConstants();
    }
    
    final public static function getInterfaces( Object | String $class )
    {
        return( self::reflect( $class ) )->getInterfaces();
    }
    
    final public static function getMethods( Object | String $class )
    {
        // ....
    }
    
    final public static function getParent( Object | String $class )
    {
        
        // New Reflection.
        $reflect = self::reflect( $class );
        
        // Check wheter if class have a parent.
        if( $reflect->getParentClass() !== False )
        {
            // Parent class name.
            $name = $reflect->getParentClass()->name;
            
            // Check wheter if class have a parent.
            if( self::getParent( $name ) !== Null )
            {
                return([ $name => self::getParent( $name )]);
            }
            return( $name );
        }
        return Null;
    }
    
    final public static function getProperties( Object | String $class )
    {
        // ....
    }
    
    final public static function getTraits( Object | String $class )
    {
        return( self::reflect( $class ) )->getTraits();
    }
    
    /*
     * Checks if in namespace.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function inNamespace( Object | String $class ): Bool;
    
    /*
     * Checks if class is abstract.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isAbstract( Object | String $class ): Bool;
    
    /*
     * Checks if class is anonymous.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isAnonymous( Object | String $class ): Bool;
    
    /*
     * Returns whether this class is cloneable.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isCloneable( Object | String $class ): Bool;
    
    /*
     * Check if class is countable.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isCountable( Object | String $class ): Bool;
    
    /*
     * Check if class is data.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isData( Object | String $class ): Bool;
    
    /*
     * Returns whether this is an enum.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isEnum( Object | String $class ): Bool;
    
    /*
     * Checks if class is final.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isFinal( Object | String $class ): Bool;
    
    abstract public static function isInstance( Object $object ): Bool;
    
    /*
     * Checks if class is instantiable.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isInstantiable( Object | String $class ): Bool;
    
    /*
     * Checks if class is interface.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isInterface( Object | String $class ): Bool;
    
    /*
     * Checks if class is defined internally by an extension, or the core.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isInternal( Object | String $class ): Bool;
    
    /*
     * Checks if class is iterable.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isIterable( Object | String $class ): Bool;
    
    /*
     * Checks if class is stringable.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isStringable( Object | String $class ): Bool;
    
    /*
     * Checks if a subclass.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isSubclassOf( Instance | string $class ): Bool;
    
    /*
     * Returns whether this is a trait.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isTrait( Object | String $class ): Bool;
    
    /*
     * Checks if user defined.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    abstract public static function isUserDefined( Object | String $class ): Bool;
    
    /*
     * Parse object or class to string.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     *
     * @return Bool
     */
    final public static function toString( Object | String $class ): String
    {
        ([
            'class' => [
                "name",
                "space"
            ],
            'object' => [
                'is' => [
                    "is::Abstract",
                    "is::Anonymous",
                    "is::Cloneable",
                    "is::Countable",
                    "is::Data",
                    "is::Enum",
                    "is::Final",
                    "is::Instance",
                    "is::Instantiable",
                    "is::Interface",
                    "is::Internal",
                    "is::Iterable",
                    "is::Stringable",
                    "is::SubclassOf",
                    "is::Throwable",
                    "is::Trait",
                    "is::UserDefined"
                ]
            ],
            'traits' => "traits",
            'methods' => "methods",
            'constants' => "constants",
            'interfaces' => "interfaces",
            'properties' => "properties"
        ]);
    }
    
}

?>