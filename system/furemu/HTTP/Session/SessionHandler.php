<?php

namespace Yume\Kama\Obi\HTTP\Session;

use Yume\Kama\Obi\Trouble;

use SessionHandler as PHPBuiltInSessionHandler;

/*
 * SessionHandler
 *
 * Just extending PHP's built-in Session Handler class.
 *
 * @package Yume\Kama\Obi\HTTP\Session
 */
final class SessionHandler extends PHPBuiltInSessionHandler
{
    
    public function __construct()
    {
        if( extension_loaded( "mstring" ) === False && 
            extension_loaded( "openssl" ) === False )
        {
            throw new Trouble\ExtensionError( "Multibyte String & OpenSSL" );
        }
    }
    
}

?>