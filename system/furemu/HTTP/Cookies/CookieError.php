<?php

namespace Yume\Kama\Obi\HTTP\Cookies;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;

use Throwable;

/*
 * CookieError
 *
 * An exception will only be thrown if there is an error in the Cookie.
 *
 * @package Yume\Kama\Obi\HTTP\Cookies
 */
class CookieError extends HTTP\HTTPError
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
     * If the expires is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_EXPIRES = 6891;
    
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
    public const INVALID_PATH = 6845;
    
    /*
     * If the samesite is not valid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_SAMESITE = 6877;
    
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    protected Array $flags = [
        self::INVALID_DOMAIN => "Domain name for {} is invalid",
        self::INVALID_EXPIRES => "Expired must have String value << 1|+1|-1 days >> | <<D, d-M-Y H:i:s T >> | << \d{1,10} >> {} is given.",
        self::INVALID_HEADER => "Invalid cookie header &gt&gt {}.",
        self::INVALID_NAME => "Cookie names must not contain any characters or symbols \\s|\\n|\\r|\\t|\\(|\\)|\\<|\\>|\\@|\\,|\\;|\\:|\\\\|\\\"|\\'|\\/|\\[|\\]|\\?|\\=|\\{|\\}, {} is given.",
        self::INVALID_PATH => "The pathname must be a valid route path, {} is given.",
        self::INVALID_SAMESITE => "The sameSite attribute must be Lax, None, or Strict, {} is given."
    ];
    
}

?>