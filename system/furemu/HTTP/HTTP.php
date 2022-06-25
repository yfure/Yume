<?php

namespace Yume\Kama\Obi\HTTP;

use Yume\Kama\Obi\Trouble;

abstract class HTTP
{
    
    /*
     * Send raw HTTP Header.
     *
     * @access Public Static
     *
     * @params String $header
     * @params Bool $replace
     * @params Int $code
     *
     * @return Void
     */
    public static function header( String $header, Bool $replace = True, Int $code = 0 ): Void
    {
        if( headers_sent() )
        {
            throw new Trouble\TypeError( "The header must be set before the output is sent." );
        }
        header( $header, $replace, $code );
    }
    
    /*
     * Get all headers.
     *
     * @access Public Static
     *
     * @return Array
     */
    public static function headers(): Array
    {
        $headers = [];
        
        $prefixs = [
            "CONTENT_TYPE" => "Content-Type",
            "CONTENT_LENGTH" => "Content-Length",
            "CONTENT_MD5" => "Content-Md5",
        ];
    
        foreach( $_SERVER as $key => $value )
        {
            // If the key prefix begins with HTTP_.
            if( substr( $key, 0, 5 ) === "HTTP_" )
            {
                // Get part of string.
                $key = substr( $key, 5 );
                
                // If the key is a header.
                if( isset( $prefixs[$key] ) !== True || isset( $_SERVER[$key] ) !== True )
                {
                    $headers[str_replace( "\x20", "-", ucwords( strtolower( str_replace( "_", "\x20", $key ) ) ) )] = $value;
                }
            } else
            
            // If the key name is a header prefix.
            if( isset( $prefixs[$key] ) )
            {
                $headers[$prefixs[$key]] = $value;
            }
        }
        
        if( isset( $headers['Authorization'] ) !== False )
        {
            if( isset( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) )
            {
                $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            } else
            if( isset( $_SERVER['PHP_AUTH_USER'] ) )
            {
                $basic_pass = isset( $_SERVER['PHP_AUTH_PW'] ) ? $_SERVER['PHP_AUTH_PW'] : "";
                $headers['Authorization'] = "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $basic_pass);
            } else
            if( isset( $_SERVER['PHP_AUTH_DIGEST'] ) )
            {
                $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
            }
        }
        
        // Return all headers.
        return $headers;
    }
    
}

?>