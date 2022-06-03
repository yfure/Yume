<?php

namespace Yume\Kama\Obi\Spl\Package;

use function Yume\Yume\Funcs\ls;

class Package
{
    
    /*
     * Retrieves the last string after the backslash.
     *
     * @access Public, Static
     *
     * @params String, Object <class>
     *
     * @return String
     */
    public static function className( String | Object $class ): String
    {
        // Convert object to string.
        $class = self::toStr( $class );
        
        // Explode class name.
        $explode = explode( "\\", $class );
        
        // Return class name
        return array_pop( $explode );
    }
    
    /*
     * Create filename based on class name.
     * If the @first parameter is filled then
     * The class name will be replaced to lowercase.
     *
     * @access Public, Static
     *
     * @params String, Object <class>
     * @params String <first>
     *
     * @return String
     */
    public static function fileName( String | Object $class, ?String $first = Null ): String
    {
        // Convert object to string.
        $class = self::toStr( $class );
        
        if( $first !== Null ) {
            
            // Replace string to lowercase.
            $class = str_replace( $first, strtolower( $first ), $class );
        }
        
        // Removes backslash.
        return preg_replace( "/\\\/", "/", "/{$class}" );
    }
    
    /*
     * Removes the last string after the backslash.
     *
     * @access Public, Static
     *
     * @params String, Object <class>
     *
     * @return String
     */
    public static function nameSpace( String | Object $class ): String
    {
        // Convert object to string.
        $class = self::toStr( $class );
        
        // Explode class name.
        $explode = explode( "\\", $class );
        
        // Removing last value array.
        array_pop( $explode );
        
        // Return name space.
        return implode( "\\", $explode );
        
    }
    
    public static function toStr( String | Object $class )
    {
        // Change value to String if contains Object.
        if( is_object( $class ) ) {
            
            // Get full class name.
            $class = $class::class;
        }
        return $class;
    }
    
}

?>