<?php

namespace Yume\Kama\Obi\Server;

/*
 * Server utility class.
 *
 * @package Yume\Kama\Obi\HTTP
 */
abstract class Server
{
    
    /*
     * Return Remote Address.
     *
     * @access Public, Static
     *
     * @return Mixed
     */
    public static function remoteAddr(): Mixed
    {
        return( SERVER_REMOTE_ADDR );
    }
    
    /*
     * Return server query string.
     *
     * @access Public, Static
     *
     * @return String, Null
     */
    public static function queryString(): ? String
    {
        return( SERVER_QUERY_STRING );
    }
    
}

?>