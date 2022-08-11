<?php

namespace Yume\Fure\AoE;

use Yume\Fure\JSON;

use ArrayAccess;
use Countable;
use Iterator;
use Serializable;
use Stringable;

/*
 * Data
 *
 * @extends Yume\Fure\AoE\Collection
 *
 * @package Yume\Fure\AoE
 */
class Data extends Overloader implements ArrayAccess, Countable, Intafesu\Unchangeable, Iterator, Stringable
{
    
    use ITraits\Collector\Access;
    use ITraits\Collector\Counter;
    
    use ITraits\Iterator\Iterator;
    
    use ITraits\Overloader\Closure;
    use ITraits\Overloader\Overload;
    use ITraits\Overloader\Regulator;
    
    /*
     * @inherit Yume\Fure\AoE\Overloader
     *
     */
    public function __construct( Array $data = [] )
    {
        // Get array keys.
        $keys = array_keys( $data );
        
        // Mapping data.
        array_map( array: $data, callback: function( $value ) use( $keys )
        {
            // Statically variable.
            static $i = 0;
            
            // If data value is array.
            if( is_array( $value ) )
            {
                $value = new Data( $value );
            }
            
            // Insert data.
            $this->data[$keys[$i++]] = $value;
        });
    }
    
    /*
     * Parse class into array.
     *
     * @access Public
     *
     * @return Array
     */
    final public function __toArray(): Array
    {
        $data = [];
        
        // Mapping data.
        foreach( $this->data As $key => $val )
        {
            // Check if data value is Data class.
            if( $val Instanceof Data )
            {
                // Get deep data.
                $val = $val->__toArray();
            }
            // Push data value.
            $data[$key] = $val;
        }
        return( $data );
    }
    
    /*
     * Parse class into string.
     *
     * @access Public
     *
     * @return String
     */
    final public function __toString(): String
    {
        return( JSON\JSON::encode( $this->__toArray(), JSON_PRETTY_PRINT ) );
    }
    
}

?>