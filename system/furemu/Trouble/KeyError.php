<?php

namespace Yume\Kama\Obi\Trouble;

/*
 * Trouble KeyError
 *
 * KeyError will be thrown if key does not exist.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class KeyError extends Error
{
    /*
     * Construct method of class KeyError.
     *
     * @access Public: Instance
     *
     * @params String $message
     * @params String $key
     * @params String $ref
     *
     * @return Static
     */
    public function __construct( ? String $message = Null, ? String $key = Null, ? String $ref = Null )
    {
        if( $message === Null )
        {
            $message = format( "Undefined key {} in {}", $key, $ref );
        }
        parent::__construct( $message );
    }
}

?>