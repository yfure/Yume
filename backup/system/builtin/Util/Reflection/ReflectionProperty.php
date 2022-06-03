<?php

namespace Yume\Kama\Obi\Reflection;

use ReflectionProperty As Property;

abstract class ReflectionProperty extends ReflectionProvider implements ReflectionInterface
{
    
    /*
     * Gets new reflection.
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return ReflectionProperty as Property.
     */
    final public static function reflect( Object | String $class, String $property ): Property
    {
        if( is_object( $class ) )
        {
            if( $class Instanceof Property )
            {
                return( $class );
            }
        }
        return( new Property( $class, $property ) );
    }
    
    /*
     * Returns the default value declared for a property.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     * @params Bool <access>
     *
     * @return Mixed.
     */
    final public static function getDefaultValue( Object | String $class, String $property, Bool $access = False ): Mixed
    {
        // New Reflection.
        $reflect = self::reflect( $class, $property );
        
        // Set Accessible property.
        $reflect->setAccessible( $access );
        
        if( $reflect->isAccessible() )
        {
            if( is_object( $class ) )
            {
                return( $reflect )->getDefaultValue( $class );
            }
            return( $reflect )->getDefaultValue();
        } else
            throw new ReflectionException( __CLASS__, "Cannot retrieve property {$property} value, Access is not allowed", ReflectionException::ACCESSIBLE );
    }
    
    /*
     * Gets value.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     * @params Bool <access>
     *
     * @return Mixed.
     */
    final public static function getValue( Object | String $class, String $property, Bool $access = False ): Mixed
    {
        // New Reflection.
        $reflect = self::reflect( $class, $property );
        
        // Set Accessible property.
        $reflect->setAccessible( $access );
        
        if( $reflect->isAccessible() )
        {
            if( is_object( $class ) )
            {
                return( $reflect )->getValue( $class );
            }
            return( $reflect )->getValue();
        } else
            throw new ReflectionException( __CLASS__, "Cannot retrieve property {$property} value, Access is not allowed", ReflectionException::ACCESSIBLE );
    }
    
    /*
     * Checks if property has a default value declared.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool.
     */
    final public static function hasDefaultValue( Object | String $class, String $property ): Bool
    {
        return( self::reflect( $class, $property ) )->hasDefaultValue();
    }
    
    /*
     * Checks if property has a type.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function hasType(): Bool;
    
    /*
     * Checks if property is a default property.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isDefault( Object | String $class, String $property ): Bool;
    
    /*
     * Checks whether a property is initialized.
     *
     * @access Public, Static
     *
     * @return Bool
     */
    abstract public static function isInitialized( ? Object | String $class, String $property ): Bool;
    
    /*
     * Checks if property is private.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isPrivate( Object | String $class, String $property ): Bool;
    
    /*
     * Checks if property is promoted.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isPromoted( Object | String $class, String $property ): Bool;
    
    /*
     * Checks if property is protected.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isProtected( Object | String $class, String $property ): Bool;
    
    /*
     * Checks if property is public.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isPublic( Object | String $class, String $property ): Bool;
    
    /*
     * Checks if property is readonly.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isReadOnly( Object | String $class, String $property ): Bool;
    
    /*
     * Checks if property is static.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     *
     * @return Bool
     */
    abstract public static function isStatic( Object | String $class, String $property ): Bool;
    
    /*
     * Set property value.
     *
     * @access Public, Static
     *
     * @params Object, String <class>
     * @params String <property>
     * @params Mixed <value>
     * @params Bool <access>
     *
     * @return ReflectionProperty as Property.
     */
    final public static function setValue( Object | String $class, String $property, Mixed $value, Bool $access = False ): Property
    {
        // New Reflection.
        $reflect = self::reflect( $class, $property );
        
        // Set Accessible property.
        $reflect->setAccessible( $access );
        
        if( $reflect->isAccessible() )
        {
            if( is_object( $class ) )
            {
                $reflect->setValue( $class, $value );
            } else {
                $reflect->setValue( $value );
            }
            return( $reflect );
        } else
            throw new ReflectionException( __CLASS__, "Cannot change property {$property} value, Access is not allowed.", ReflectionException::ACCESSIBLE );
    }
    
}

?>