<?php

namespace Yume\Kama\Obi\HTTP\Cookies;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Trouble;

/*
 * CookieError
 *
 * An exception will only be thrown if there is an error in the Cookie.
 *
 * @package Yume\Kama\Obi\HTTP\Cookies
 */
class CookieError extends Trouble\Error
{
    
    /*
     * If the domain is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_DOMAIN = 6861;
    
    /*
     * If the header is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_HEADER = 6888;
    
    /*
     * If the name is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_NAME = 6828;
    
    /*
     * If the path is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_PATH = 6245;
    
    /*
     * If the samesite is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_SAMESITE = 6877;
    
    /*
     * Construct method of class CookieError
     *
     * @access Public Instance
     *
     * @params String $subject
     * @params Int $flags
     * @params Throwable $prev
     *
     * @return Static
     */
    public function __construct( String $subject, Int $flags = 0, ? Throwable $prev = Null )
    {
        if( $flags !== 0 )
        {
            $match = match( $flags )
            {
                // If the domain is not valid.
                self::INVALID_DOMAIN => "Domain name for {} is invalid",
                
                // If the header is not valid.
                self::INVALID_HEADER => "Invalid cookie header &gt&gt {}.",
                
                // If the name is not valid.
                self::INVALID_NAME => "Cookie names must not contain any characters or symbols \\s|\\n|\\r|\\t|\\(|\\)|\\<|\\>|\\@|\\,|\\;|\\:|\\\\|\\\"|\\'|\\/|\\[|\\]|\\?|\\=|\\{|\\}, {} is given.",
                
                // If the path is not valid.
                self::INVALID_PATH => "The pathname must be a valid route path, {} is given.",
                
                // If the samesite is not valid.
                self::INVALID_SAMESITE => "The sameSite attribute must be Lax, None, or Strict, {} is given.",
                
                // If the flag is invalid.
                default => "Invalid flag, unknown error.",
                
            };
            $subject = f( $match, AoE\Stringable::parse( $subject ) );
        }
        parent::__construct( $subject, $flags, $prev );
    }
    
}

?>