<?php

namespace Yume\Fure\Reflector;

use Yume\Fure\AoE;
use Yume\Fure\Error;

use ReflectionException;
use ReflectionProperty;
use ReflectionType;

/*
 * ReflectProperty
 *
 * @package Yume\Fure\Reflector
 */
abstract class ReflectProperty
{
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.getdefaultvalue.php
     *
     */
    public static function getDefaultValue( Object | String $class, String $name, Mixed &$ref = Null ): Mixed
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->getDefaultValue();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.getdoccomment.php
     *
     */
    public static function getDocComment( Object | String $class, String $name, Mixed &$ref = Null ): String | False
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->getDocComment();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.getmodifiers.php
     *
     */
    public static function getModifiers( Object | String $class, String $name, Mixed &$ref = Null ): int
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->getModifiers();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.getname.php
     *
     */
    public static function getName( Object | String $class, String $name, Mixed &$ref = Null ): String
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->getName();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.gettype.php
     *
     */
    public static function getType( Object | String $class, String $name, Mixed &$ref = Null ): ? ReflectionType
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->getType();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.getvalue.php
     *
     */
    public static function getValue( Object | String $class, String $name, Mixed &$ref = Null ): Mixed
    {
        // Check if property is not public.
        if( self::isPublic( $class, $name, $ref ) === False )
        {
            // Set property accessibility.
            $ref->setAccessible( True );
        }
        
        // Get property value.
        $value = is_object( $class ) ? $ref->getValue( $class ) : $ref->getValue();
        
        // Set property accessibility.
        $ref->setAccessible( $ref->isPublic() ? True : False );
        
        return( $value );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.hasdefaultvalue.php
     *
     */
    public static function hasDefaultValue( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->hasDefaultValue();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.hastype.php
     *
     */
    public static function hasType( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->hasType();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.isdefault.php
     *
     */
    public static function isDefault( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isDefault();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.isinitialized.php
     *
     */
    public static function isInitialized( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        // Construct a ReflectionProperty object.
        $ref = new ReflectionProperty( $class, $name );
        
        return( is_object( $class ) ? $ref->isInitialized( $object ) : $ref->isInitialized() );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.isprivate.php
     *
     */
    public static function isPrivate( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isPrivate();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.ispromoted.php
     *
     */
    public static function isPromoted( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isPromoted();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.isprotected.php
     *
     */
    public static function isProtected( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isProtected();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.ispublic.php
     *
     */
    public static function isPublic( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isPublic();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.isreadonly.php
     *
     */
    public static function isReadOnly( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isReadOnly();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.isstatic.php
     *
     */
    public static function isStatic( Object | String $class, String $name, Mixed &$ref = Null ): Bool
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->isStatic();
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.setaccessible.php
     *
     */
    public static function setAccessible( Object | String $class, String $name, Bool $accessible, Mixed &$ref = Null ): ReflectionMethod
    {
        return( $ref = new ReflectionProperty( $class, $name ) )->setAccessible( $accessible );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/reflectionproperty.setvalue.php
     *
     */
    public static function setValue( Object | String $class, String $name, Mixed $value, Mixed &$ref = Null ): Void
    {
        // Check if class is Unchangeable
        if( ReflectClass::isImplements( $class, AoE\Intafesu\Unchangeable::class, $ref ) )
        {
            throw new Error\TypeError( "It is forbidden to change property values   of classes implementing Yume\Fure\AoE\Intafesu\Unchangeable Interfaces." );
        } else {
            
            // Get Property Class Reflection.
            $ref = $ref->getProperty( $name );
            
            // Check if property is not public.
            if( $ref->isPublic() == False )
            {
                // Set property accessibility.
                $ref->setAccessible( True );
            }
            
            // Compares two "PHP-standardized" version number strings.
            if( version_compare( PHP_VERSION, "8.1.0" ) >= 1 )
            {
                // Check if property is readonly.
                if( $ref->isReadOnly() )
                {
                    throw new Error\TypeError( "It is forbidden to change the Readonly property value." );
                }
            }
            
            // Check if class name is object.
            if( is_object( $class ) )
            {
                $ref->setValue( $class, $value );
            } else {
                $ref->setValue( $value );
            }
            
            // Set property accessibility.
            $ref->setAccessible( $ref->isPublic() ? True : False );
        }
    }
    
}

?>