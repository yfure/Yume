<?php

namespace Yume\Fure\AoE\ITraits\Collector;

/*
 * Counter
 *
 * @package Yume\Fure\AoE\Collector
 */
trait Counter
{
    use \Yume\Fure\AoE\ITraits\Overloader\Overload;
    
    /*
     * Return the total value of data.
     *
     * @access Public
     *
     * @return Int
     */
    public function count(): Int
    {
        if( is_array( $this->data ) )
        {
            return( count( $this->data ) );
        }
        return( 0 );
    }
}

?>