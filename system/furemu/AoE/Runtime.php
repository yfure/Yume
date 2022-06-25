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
            
            $cookie = \Yume\Kama\Obi\HTTP\Cookies\Cookie::set( "test", "Testing!" );
            
            echo $cookie;
            echo "\n";
            echo \Yume\Kama\Obi\HTTP\Cookies\Cookie::parse( $cookie );
            
        }
        
    }
    
}

?>