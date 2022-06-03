<?php

namespace Yume\Kama\Obi\Runtime
{
    
    use Yume\Kama\Obi\Arguments;
    use Yume\Kama\Obi\AoE;
    use Yume\Kama\Obi\HTTP;
    use Yume\Kama\Obi\Spl;
    
    class Runtime
    {
        
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
                self::cli();
            } else {
                
                /** Start as web server. */
                self::web();
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
            
            // Importing routes.
            Spl\Loader\Loader::import( "/system/routes/web" );
            
            // Dispatch route.
            HTTP\Route\RouteDispatch::dispatch();
            
        //    var_dump( AoE\App::$object->routes );
        }
        
    }
    
}

?>