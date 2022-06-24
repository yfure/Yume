<?php

namespace Yume\Kama\Obi\AoE;

final class Runtime
{
    
    public static function buff(): Void
    {
        
        App::buff();
        
        if( CLI )
        {
            /*
             * Handle command line arguments.
             *
             * It will serve just as it would build controllers,
             * Components, models, and so on. If no command is sent,
             * The program will be terminated.
             */
            echo "Hello World!";
            
        } else {
            
            // Start as web server.
            
            $matchs = [];
            
            $cookie = \Yume\Kama\Obi\HTTP\Cookies\Cookie::set( "test", "Testing!" );
            $cookie->comment = "This is testing!";
            $cookie->domain = "hxari.github.io";
            $cookie->expires = 90;
            $cookie->httpOnly = True;
            $cookie->maxAge = 60;
            $cookie->path = "/";
            $cookie->sameSite = "Strict";
            $cookie->version = "7.9";
            
            $cookie = \Yume\Kama\Obi\HTTP\Cookies\Cookie::parse( $cookie );
            
            echo $cookie;
            
        }
        
    }
    
}

?>