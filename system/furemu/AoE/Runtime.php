<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\HTTP;

final class Runtime
{
    
    public static ? App $app = Null;
    
    public static ? Array $matchs = [];
    
    public static function buff(): Void
    {
        
        // Check if the application already exists.
        if( self::$app Instanceof App )
        {
            throw new Trouble\RuntimeError( "Application initialization found, application cannot be duplicated." );
        }
        
        // Initialize app.
        self::$app = new App;
        
        // Run application services.
        self::$app->service();
        
        /*
         * Replace anything.
         *
         */
        Replace::class;
        
        if( CLI )
        {
            /*
             * Handle command line arguments.
             *
             * It will serve just as it would build controllers,
             * Components, models, and so on. If no command is sent,
             * The program will be terminated.
             */
            
        } else {
            
            // Starting new session.
            HTTP\Session\Session::start();
            
            // 
            
        }
    }
}

?>