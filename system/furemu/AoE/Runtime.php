<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\HTTP;

final class Runtime
{
    public static $matchs = [];
    
    public static function buff(): Void
    {
        App::buff();
        
        /*
         * Replace anything.
         *
         */
        replace( "system", tree( "system" ), function( String $fname, String $fread ): String
        {
            if( $match = \Yume\Kama\Obi\RegExp\RegExp::matchs( "/(?:(.*?)(Error)(.*?))/m", str_replace( [ "\t", "\x20\x20\x20\x20" ], "", $fread ) ) )
            {
                self::$matchs[] = $fname;
            }
            return( $fread );
        });
        
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
            
            // Starting new session.
            HTTP\Session\Session::start();
            
            // ....
            
            // Destroy current Session.
            HTTP\Session\Session::destroy();
        }
    }
}

?>