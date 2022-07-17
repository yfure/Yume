<?php

namespace Yume\Kama\Obi\Reflector;

use Yume\Kama\Obi\AoE;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/*
 * ReflectClass
 *
 * The ReflectClass class reports information about a class.
 *
 * @package Yume\Kama\Obi\Reflector
 */
abstract class ReflectClass
{
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.newinstance.php
     * @inherit https://www.php.net/manual/en/reflectionclass.newinstanceargs.php
     *
     */
    final public static function instance( String | Object $class, Array $args = [], Mixed &$ref = Null ): Object
    {
        // Constructs a ReflectionClass.
        $reflect = $ref = is_object( $class ) && $class Instanceof ReflectionClass ? $class : new ReflectionClass( $class );
        
        // Check if the class has a constructor.
        if( $reflect->getConstructor() !== Null )
        {
            // Checks if the constructor has parameters.
            if( count( $parameter = $reflect->getConstructor()->getParameters() ) > 0 )
            {
                return( $reflect )->newInstanceArgs( ReflectParameter::bind( $parameter, $args ) );
            }
        }
        return( $reflect->newInstance() );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.getconstants.php
     *
     */
    final public static function getConstants( Object | String $class, Bool $onlyName = False, Mixed &$ref = Null ): Array
    {
        return( $ref = new ReflectionClass( $class ) )->getConstants();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.getinterfaces.php
     *
     */
    final public static function getInterfaces( Object | String $class, Bool $onlyName = False, Mixed &$ref = Null ): Array
    {
        if( $onlyName )
        {
            return( $ref = new ReflectionClass( $class ) )->getInterfaceNames();
        }
        return( $ref = new ReflectionClass( $class ) )->getInterfaces();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.getmethods.php
     *
     */
    final public static function getMethods( Object | String $class, Int $filter = ReflectionMethod::IS_PUBLIC, Bool $onlyName = False )
    {
        // Get all methods by filter.
        $methods = ( $ref = new ReflectionClass( $class ) )->getMethods( $filter );
        
        // Check if only the name is needed.
        if( $onlyName )
        {
            // Mapping methods.
            $methods = array_map( array: $methods, callback: fn( $method ) => $method->name );
        }
        
        return( $methods );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.getparentclass.php
     *
     */
    final public static function getParent( Object | String $class, Mixed &$ref = Null ): Bool | ReflectionClass
    {
        return( $ref = new ReflectionClass( $class ) )->getParentClass();
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
    final public static function getParentTree( Object | String $class, Mixed &$ref = Null ): Array | String | Null
    {
        // Get reflection for parent class.
        $parent = self::getParent( $class );
        
        // If the parent instance of ReflectionClass.
        if( $parent Instanceof ReflectionClass )
        {
            // Looping.
            $tree = self::getParentTree( $parent->name );
            
            // If parent also has parent.
            if( $tree !== Null )
            {
                // ...
                $class = [ $parent->name, $tree ];
                
                // Tidying up the array.
                foreach( $class As $i => $name )
                {
                    if( is_array( $name ) )
                    {
                        // Remove array class.
                        unset( $class[$i] );
                        
                        // ...
                        $class = [ ...$class, ...$name ];
                    }
                }
                return( $class );
            }
            return( $parent->name );
        }
        return Null;
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.getproperties.php
     *
     */
    final public static function getProperties( Object | String $class, Int $filter = ReflectionProperty::IS_PUBLIC, Bool $onlyName = False, Mixed &$ref = Null ): Array
    {
        // Get all properties by filter.
        $props = ( $ref = new ReflectionClass( $class ) )->getProperties( $filter );
        
        // Check if only the name is needed.
        if( $onlyName )
        {
            // Mapping properties.
            $props = array_map( array: $props, callback: fn( $prop ) => $prop->name );
        }
        
        return( $props );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.gettraits.php
     *
     */
    final public static function getTraits( Object | String $class )
    {
        return( $ref = new ReflectionClass( $class ) )->getTraits();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.innamespace.php
     *
     */
    final public static function inNamespace( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->inNameSpace();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isabstract.php
     *
     */
    final public static function isAbstract( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isAbstract();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isanonymous.php
     *
     */
    final public static function isAnonymous( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isAnonymous();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.iscloneable.php
     *
     */
    final public static function isCloneable( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isCloneable();
    }
    
    /*
     * ....
     *
     */
    abstract public static function isCountable( Object | String $class, Mixed &$ref = Null ): Bool;
    
    /*
     * ....
     *
     */
    abstract public static function isData( Object | String $class, Mixed &$ref = Null ): Bool;
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isenum.php
     *
     */
    final public static function isEnum( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isEnum();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isfinal.php
     *
     */
    final public static function isFinal( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isFinal();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.implementsinterface.php
     *
     */
    final public static function isImplements( Object | String $class, ReflectionClass | String $interface, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->implementsInterface( $interface );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isinstance.php
     *
     */
    final public static function isInstance( Object $object, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isInstance();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isinstantiable.php
     *
     */
    final public static function isInstantiable( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isInstantiable();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isinterface.php
     *
     */
    final public static function isInterface( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isInterface();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isinternal.php
     *
     */
    final public static function isInternal( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isInternal();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isiterable.php
     *
     */
    final public static function isIterable( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isIterable();
    }
    
    /*
     * ...
     *
     */
    abstract public static function isStringable( Object | String $class, Mixed &$ref = Null ): Bool;
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.issubclassof.php
     *
     */
    final public static function isSubclassOf( Object | String $class, ReflectionClass | String $object, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isSubclassOf( $object );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.istrait.php
     *
     */
    final public static function isTrait( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isTrait();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionclass.isuserdefined.php
     *
     */
    final public static function isUserDefined( Object | String $class, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionClass( $class ) )->isUserDefined();
    }
    
}

?>