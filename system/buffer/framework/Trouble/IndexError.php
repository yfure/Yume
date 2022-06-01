<?php

namespace Yume\Kama\Obi\Trouble;

/*
 * Trouble IndexError
 *
 * IndexError thrown when index not found.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class IndexError extends Error
{
    /*
     * Construct method of class IndexError.
     *
     * @access Public: Instance
     *
     * @params String: $message
     * @params Int: $range
     * @params String: $ref
     *
     * @return Static
     */
    public function __construct( ? String $message = Null, ? Int $range = Null, ? String $ref = Null )
    {
        if( $message === Null )
        {
            $message = format( "Index {} out of range in {}.", $range, $ref );
        }
        parent::__construct( $message );
    }
}

?>