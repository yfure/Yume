<?php

namespace Yume\Kama\Obi\Trouble;

use Yume\Kama\Obi\Reflector;

use Error;
use Throwable;

/*
 * Error
 *
 * Just extending PHP's built-in Error class.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class TroubleError extends Error
{
    
    /*
     * Value of flag (e.g...[ self::NAME_ERROR => "Name for {} is undefined" ])
     *
     * @access Public
     *
     * @values Array
     */
    public Array $flags = [];
    
    /*
    * Construct method of class TroubleError
    *
    * @access Public Instance
    *
    * @params String $subject
    * @params Int $flags
    * @params Throwable $prev
    *
    * @return Void
    */
    public function __construct( ? String $message = Null, Int $code = self::UNKNOWN, ? Throwable $prev = Null )
    {
        // If the error thrown has a flag.
        if( $code !== 0 )
        {
            // If the flag is available.
            if( isset( $this->flags[$code] ) )
            {
                $message = f( $this->flags[$code], $message );
            } else {
                $message = f( "Invalid flag {}, unknown error type.", $code );
            }
        }
        parent::__construct( $message, $code, $prev );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     */
    public function __toString(): String
    {
        return( path( remove: True, path: f( "{}: {} on file {} line {} code {}.", $this::class, $this->message, $this->file, $this->line, $this->code ) ) );
    }
}

?>