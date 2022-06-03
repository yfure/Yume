<?php

namespace Yume\Kama\Obi\Runtime
{
    
    use Yume\Kama\Obi\Arguments;
    use Yume\Kama\Obi\AoE;
    use Yume\Kama\Obi\HTTP;
    
    /*
     * Runtime class utility.
     *
     * @package Yume\Kama\Obi\Runtime
     */
    final class Runtime
    {
        
        /*
         * Select application runtime mode.
         *
         * @access Public, Static
         *
         * @return Void
         */
        public static function app(): Void
        {
            
            AoE\App::init();
            
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
        
        protected static function cli(): Void
        {
            // Unhandled code...
            var_dump( getopt() );
        }
        
        protected static function web(): Void
        {
            // Create collection for routes.
            AoE\App::$object->routes = new AoE\Data;
            
            // Create route service instance.
            AoE\App::$object->routeService = new HTTP\Route\RouteService;
            
            // Run route service bootstrap.
            AoE\App::$object->routeService->bootstrap();
            
            // Dispatch route.
            HTTP\Route\RouteDispatch::dispatch();
            
        }
        
    }
    
}

?>