<?php

namespace Yume\Fure\Threader;

use Yume\Fure\AoE;
use Yume\Fure\Error;
use Yume\Fure\HTTP;

/*
 * Runtime
 *
 * Application runtime.
 *
 * @package Yume\Fure\Threader
 */
final class Runtime implements AoE\Intafesu\Unchangeable
{
    
    /*
     * Application class instance.
     *
     * @access Public Static
     *
     * @values Yume\Fure\Threader\App
     */
    public static ? App $app = Null;
    
    /*
     * Router class instance.
     *
     * @access Public Protected
     *
     * @values Yume\Fure\HTTP\Routing\Router
     */
    protected static HTTP\Routing\Router $router;
    
    /*
     * Runtime initialization.
     *
     * @access Public Static
     *
     * @return Void
     */
    public static function start(): Void
    {
        
        // Check if the application already exists.
        if( self::$app Instanceof App )
        {
            throw new Error\RuntimeError( "Application initialization found, application cannot be duplicated." );
        }
        
        // Initialize app.
        self::$app = App::create();
        
        // {}
        
        /*
         * Handle command line arguments.
         *
         * It will serve just as it would build controllers,
         * Components, models, and so on. If no command is sent,
         * The program will be terminated.
         *
         * Note! This is only for linux system no windows!
         */
        if( CLI )
        {
            // Clear terminal screen.
            system( "clear" );
            
            if( in_array( "server", $_SERVER['argv'] ) )
            {
                // Starting web server.
                exit( system( f( "php -S {}:{} public/index.php", env( "SERVER_HOST" ), env( "SERVER_PORT" ) ) ) );
            }
        } else {
            
            // Create new router instance.
            self::$router = new HTTP\Routing\Router;
            
            // Create application routing.
            self::$router->create();
            
            // Dispatch route.
            self::$router->dispatch();
            
        }
    }
    
}

?>