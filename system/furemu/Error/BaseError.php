<?php

namespace Yume\Fure\Error;

use Yume\Fure\Reflector;

use Error;
use Throwable;

/*
 * BaseError
 *
 * The main Error class in Yume.
 *
 * @package Yume\Fure\Error
 */
class BaseError extends Error implements Throwable
{
    use \Yume\Fure\AoE\ITraits\Exception;

    /*
     * Construct method of class BaseError
     *
     * @access Public Instance
     *
     * @params Array|String $message
     * @params Int $code
     * @params Throwable $previous
     *
     * @return Void
     */
    public function __construct( Null | Array | String $message = Null, Int $code = 0, ? Throwable $previous = Null )
    {
        // If the error thrown has a flag.
        if( count( $this->flags ) > 0 && $code !== 0 )
        {
            // If the flag is available.
            if( isset( $this->flags[$code] ) )
            {
                $message = f( $this->flags[$code], $message );
            } else {
                $message = f( "Invalid flag \"{}\", unknown error type.", $code );
            }
        }
        
        // Get constant name.
        if( $type = array_search( $code, Reflector\ReflectClass::getConstants( $this ) ) )
        {
            // Set error type based on constant name.
            $this->type = $type;
        }
        
        parent::__construct( $message, $code, $previous );
    }
}

?>