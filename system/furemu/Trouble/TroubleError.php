<?php

namespace Yume\Kama\Obi\Trouble;

use Yume\Kama\Obi\Reflector;

use Error;
use Throwable;

/*
 * TroubleError
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
     * @access Protected
     *
     * @values Array
     */
    protected Array $flags = [];
    
    /*
     * Error type string
     *
     * @access Protected
     *
     * @values String
     */
    protected String $type = "None";
    
    /*
    * Construct method of class TroubleError
    *
    * @access Public Instance
    *
    * @params Array|String $subject
    * @params Int $flags
    * @params Throwable $prev
    *
    * @return Void
    */
    public function __construct( Null | Array | String $message = Null, Int $code = 0, ? Throwable $prev = Null )
    {
        // If the error thrown has a flag.
        if( count( $this->flags ) > 0 && $code !== 0 )
        {
            // If the flag is available.
            if( isset( $this->flags[$code] ) )
            {
                   $message = f( $this->flags[$code], $message );
            } else {
                $message = f( "Invalid flag {}, unknown error type.", $code );
            }
            
            // Get constant name.
            if( $type = array_search( $code, Reflector\Kurasu::getConstants( $this ) ) )
            {
                // Set error type based on constant name.
                $this->type = $type;
            }
        }
        parent::__construct( $message, $code, $prev );
    }
    
    /*
     * Get error type string.
     *
     * @access Public
     *
     * @return String
     */
    public function getType(): String
    {
        return( $this->type );
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