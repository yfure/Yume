<?php

namespace Yume\Kama\Obi\AoE;

abstract class Runtime
{
    
    public static function buff(): Void
    {
        
        App::buff();
        
        if( isCommandLineInterface )
        {
            /*
             * Handle command line arguments.
             *
             * It will serve just as it would build controllers,
             * Components, models, and so on. If no command is sent,
             * The program will be terminated.
             */
            
        } else {
            
            // Start as web server.
            
        }
        
    }
    
}

?>