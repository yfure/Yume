<?php

namespace Yume\Kama\Obi\HTTP;

/*
 * Input utility class.
 *
 * @package Yume\Kama\Obi\HTTP
 */
abstract class Input extends Request
{
    
    public const EMAIL_PATTERN = "//";
    public const UNAME_PATTERN = "//";
    public const PASSW_PATTERN = "//";
    public const PHONE_PATTERN = "//";
    
    /*
     * Returns the value of the POST request,
     * received by the server, and validates it.
     *
     * Note that validating only equalizes based
     * on the regexp pattern and it doesn't
     * replace any characters.
     *
     * @access Public, Static
     *
     * @params String <key>
     * @params String <pattern>
     *
     * @return Mixed
     */
    final public static function post( String $key, String $pattern = Null ): Mixed
    {
        if( isset( $_POST[$key] ) )
        {
            if( $pattern !== Null )
            {
                return([
                    
                    'input' => $_POST[$key],
                    
                    // Validate user input.
                    'valid' => Filter\RegExp::match( $pattern, $_POST[$key] )
                ]);
            }
            return( $_POST[$key] );
        }
        return( Null );
    }
    
}

?>