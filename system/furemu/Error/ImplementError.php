<?php

namespace Yume\Fure\Error;

use Throwable;

/*
 * ImplementError
 *
 * @extends Yume\Fure\Error\BaseError
 *
 * @package Yume\Fure\Error
 */
class ImplementError extends BaseError
{
    
    /*
     * @inhetit Yume\Fure\Error\BaseError
     *
     */
    public function __construct( Array | String $message, Int $code = 0, ? Throwable $previous = Null )
    {
        // Check if message is array.
        if( is_array( $message ) )
        {
            $message = f( "Tokenization class {} must implement Interface {}.", $message );
        }
        parent::__construct( $message, $code, $previous );
    }
    
}

?>