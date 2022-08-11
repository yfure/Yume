<?php

namespace Yume\Fure\AoE\ITraits;

/*
 * Serialize
 *
 * @package Yume\Fure\AoE\ITraits
 */
trait Serialize
{
    use Overloader\Overload;
    
    /*
     * String representation of object.
     *
     * @access Public
     *
     * @return String
     */
    public function serialize(): ? String
    {
        if( $this->data === Null )
        {
            return( Null );
        }
        return( serialize( $this->data ) );
    }
    
    /*
     * Constructs the object.
     *
     * @access Public
     *
     * @params String $data
     *
     * @return Void
     */
    public function unserialize( String $data ): Void
    {
        $this->data = unserialize( $data );
    }
    
}

?>