<?php

namespace Yume\Kama\Obi\Reflection;

use ReflectionProperty;

class Property
{
    /*
     * The property method reports information about class properties.
     *
     * @access Public, Static
     *
     * @params String <property>
     * @params String, Object <class>
     *
     * @return ReflectionProperty
     */
    public static function reflect( String $property, String | Object $class = __CLASS__ ): ReflectionProperty
    {
        return( new ReflectionProperty( $class, $property ) );
    }
    
    public static function refresh( Object $class, Int $filter = Null ): Object
    {
        // ....
        $r = self::property( $class, $filter );
        
        foreach( $r As $single ) {
            
            self::setValue( $single->name, Null, $class );
        }
        return( $object );
    }
    
    public static function property( String | Object $class, ?Int $filter = Null ): Array
    {
        if( $filter === Null ) {
            $filter = ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED;
        }
        
        // ....
        return( Instance::reflect( $class ) )->getProperties( $filter );
    }
    
    public static function getValue( String $property, Object $class ): Mixed
    {
        // Get ReflectionProperty class instance.
        $r = self::reflect( $property, $class );
        
        // Translucent property permits.
        $r->setAccessible( True );
        
        // Return property value.
        return( $r )->getValue( $class );
    }
    
    public static function setValue( String $property, Mixed $value, Object $class ): Object
    {
        // Get ReflectionProperty class instance.
        $r = self::reflect( $property, $class );
        
        // Translucent property permits.
        $r->setAccessible( True );
        
        // Set new value for property.
        $r->setValue( $class, $value );
        
        return $class;
    }
    
}

?>