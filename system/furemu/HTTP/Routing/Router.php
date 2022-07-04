<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\AoE;

class Router //implements RouterInterface
{
    
    /*
     * Routes class instance.
     *
     * @access Protected
     *
     * @values Yume\Kama\Obi\HTTP\Routing\Routes
     */
    protected Routes $routes;
    
    public function __construct()
    {
        // Create new Route Collection.
        AoE\Runtime::$app->object->routes = $this->routes = new Routes;
    }
    
    /*
     * Create new routing.
     *
     * @access Public
     *
     * @return Void
     */
    public function create(): Void
    {
        // Import the file containing the route.
        AoE\Package::import( AoE\App::config( "http.routing.routes" ) );
    }
    
    /*
     * Route dispatch.
     *
     * @access Public
     *
     * @return Void
     */
    public function dispatch(): Void
    {
        var_dump( $this->routes );
    }
    
}

?>