<?php

namespace Yume\Fure\AoE\ITraits\Collector;

/*
 * Access
 *
 * @package Yume\Fure\AoE\Collector
 */
trait Access
{
    use \Yume\Fure\AoE\ITraits\Overloader\Overload;
    
    /*
     * Assigns a value to the specified offset.
     *
     * @access Public
     *
     * @params Mixed <offset>
     * @params Mixed <value>
     *
     * @return Void
     */
    public function offsetSet( Mixed $offset, Mixed $value ): Void
    {
        if( is_null( $offset ) )
        {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }
    
    /*
     * Whether or not an offset exists.
     *
     * @access Public
     *
     * @params Mixed <offset>
     *
     * @return Bool
     */
    public function offsetExists( Mixed $offset ): Bool
    {
        return( isset( $this->data[$offset] ) );
    }
    
    /*
     * Unsets an offset.
     *
     * @access Public
     *
     * @params Mixed <offset>
     *
     * @return Void
     */
    public function offsetUnset( Mixed $offset ): Void
    {
        if( $this->offsetExists( $offset ) )
        {
            unset( $this->data[$offset] );
        }
    }
    
    /*
     * Returns the value at specified offset.
     *
     * @access Public
     *
     * @params Mixed <offset>
     *
     * @return Mixed
     */
    public function offsetGet( Mixed $offset ): Mixed
    {
        return( $this->offsetExists( $offset ) ? $this->data[$offset] : Null );
    }
}

?>