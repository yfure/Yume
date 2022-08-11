<?php

namespace Yume\Fure\AoE\ITraits\Overloader;

use Yume\Fure\AoE;

/*
 * Stringer
 *
 * @package Yume\Fure\AoE\ITraits\Overloader
 */
trait Stringer
{
    use Overload;
    
    /*
     * Allows a class to decide how it will react when it is treated like a string.
     *
     * @access Public
     *
     * @return String
     */
    public function __toString(): String
    {
        return( AoE\Stringer::parse( $data ) );
    }
    
}

?>