<?php

namespace Yume\Kama\Obi\HTTP;

/*
 * HTTP utility class.
 *
 * @package Yume\Kama\Obi\HTTP
 */
abstract class Http
{
    
    use \Yume\Kama\Obi\AoE\Config;
    
    /*
     * Send a raw HTTP header.
     *
     * @access Public, Static
     *
     * @params String <header>
     * @params Bool <replace>
     * @params Int <code>
     *
     * @return Void
     */
    public static function header( String $header, Bool $replace = True, Int $code = 0 ): Void
    {
        header( $header, $replace, $code );
    }
    
    /*
     * Content type response detection.
     *
     * @access Public, Static
     *
     * @params String <response>
     * @params String <charset>
     *
     * @return String
     */
    public static function response( String $response, String $charset = "" ): String
    {
        foreach( self::config( "response.type" ) As $type => $res )
        {
            if( $response === $type )
            {
                return( "Content-Type:{$res['Content-Type']}" );
            }
        }
        return( $response );
    }
    
}

?>