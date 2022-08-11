<?php

namespace Yume\Fure\Reflector;

use Closure;

use ReflectionClass;
use ReflectionMethod;

/*
 * ReflectMethod
 *
 * @package Yume\Fure\Reflector
 */
abstract class ReflectMethod
{
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.getclosure.php
     *
     */
    public static function getClosure( Object | String $class, String $name, Mixed &$ref = Null ): Closure
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->getClosure( is_object( $class ) ? $class : Null );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.getmodifiers.php
     *
     */
    public static function getModifiers( Object | String $class, String $name, Mixed &$ref = Null ): Int
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->getModifiers();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.getprototype.php
     *
     */
    public static function getPrototype( Object | String $class, String $name, Mixed &$ref = Null ): ReflectionMethod
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->getPrototype();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.invoke.php
     * @inherit https://www.php.net/manual/en/reflectionmethod.invokeargs.php
     *
     */
    public static function invoke( Object | String $class, String $name, Array $args = [], Mixed &$ref = Null ): Mixed
    {
        // Check if object is ReflectionClass.
        if( $class Instanceof ReflectionClass )
        {
            // Copy ReflectionClass instance.
            $rec = $class;
            
            // Get Reflection method instance.
            $ref = $class->getMethod( $name );
            
            // Get class name.
            $class = $class->getName();
        } else {
            
            // Get Reflection method instance.
            $ref = new ReflectionMethod( $class, $name );
            
            // Reflection class instance.
            $rec = $ref->getDeclaringClass();
        }
        
        // Get method parameters.
        $params = ReflectParameter::bind( $ref->getParameters(), $args );
        
        // Check if class is abstract.
        if( $rec->isAbstract() )
        {
            // Call a callback with an array of parameters.
            $result = call_user_func_array( f( "{}::{}", $rec->getName(), $name ), $params );
        } else {
            
            // Get class instance.
            $instance = is_object( $class ) ? $class : ReflectClass::instance( $class );
            
            // Check if method is not public.
            if( $ref->isPublic() === False )
            {
                // Set method accessibility.
                $ref->setAccessible( True );
            }
            
            // Check if method has parameters.
            if( count( $params ) > 0 )
            {
                // Invoke method with parameters.
                $result = $ref->invokeArgs( $instance, $params );
            } else {
                
                // Invoke method with parameters.
                $result = $ref->invoke( $instance );
            }
            
            // Set method accessibility.
            $ref->setAccessible( $ref->isPublic() ? True : False );
        }
        
        // Return the return value of the method.
        return( $result );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isabstract.php
     *
     */
    public static function isAbstract( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isAbstract();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isconstructor.php
     *
     */
    public static function isConstructor( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isConstructor();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isdestructor.php
     *
     */
    public static function isDestructor( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isDestructor();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isfinal.php
     *
     */
    public static function isFinal( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isFinal();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isprivate.php
     *
     */
    public static function isPrivate( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isPrivate();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isprotected.php
     *
     */
    public static function isProtected( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isProtected();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.ispublic.php
     *
     */
    public static function isPublic( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isPublic();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.isstatic.php
     *
     */
    public static function isStatic( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->isStatic();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionmethod.setaccessible.php
     *
     */
    public static function setAccessible( Object | String $class, String $name, Bool $accessible, Mixed &$ref = Null ): ReflectionMethod
    {
        return( $ref = new ReflectionMethod( $class, $name ) )->setAccessible( $accessible );
    }
    
}

?>