<?php

namespace Yume\Fure\AoE\ITraits\Overloader;

use Yume\Fure\Reflector;

use ReflectionProperty;

/*
 * Serialize
 *
 * For general purposes note that methods of this
 * nature only work with private properties.
 *
 * @package Yume\Fure\AoE\Overloader
 */
trait Serialize
{
    
    /*
     * https://www.php.net/manual/en/language.oop5.magic.php#object.serialize
     *
     * @access Public
     *
     * @return Array
     */
    public function __serialize(): Array
    {
        // ...
        $data = [];
        
        // Get all private property from class.
        $property = Reflector\ReflectClass::getProperties( $this, ReflectionProperty::IS_PRIVATE );
        
        // Mapping properties.
        $property = array_map( array: $property, callback: function( $reflect ) use( &$data )
        {
            return( $data[$reflect->getName()] = $reflect->getValue( $this ) );
        });
        
        return( $data );
    }
    
    /*
     * https://www.php.net/manual/en/language.oop5.magic.php#object.unserialize
     *
     * @access Public
     *
     * @params Array $data
     *
     * @return Void
     */
    public function __unserialize( Array $data ): Void
    {
        // Get array keys.
        $keys = array_keys( $data );
        
        // Mapping data.
        array_map( array: $data, callback: function( $val ) use( $keys )
        {
            // Statically variable.
            static $i = 0;
            
            // If property is exists.
            if( property_exists( $this, $keys[$i] ) )
            {
                // Create new property reflection.
                $reflect = new ReflectionProperty( $this, $keys[$i] );
                
                // Check if property is readonly.
                if( $reflect->isReadonly() )
                {
                    throw new Error\SerializeError( $keys[$i], SerializeError::IS_READONLY );
                }
                
                // Check if property is private.
                if( $reflect->isPrivate() )
                {
                    // Insert data.
                    return( $this->{ $keys[$i++] } = $val );
                }
                throw new Error\SerializeError( $keys[$i], SerializeError::NOT_PRIVATE );
            }
            throw new Error\PropertyError( $keys[$i], PropertyError::UNDEFINED );
        });
    }
    
}

?>