<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\RegExp;

/*
 * Router
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
class Router implements RouterInterface
{
    
    /*
     * Routes class instance.
     *
     * @access Protected
     *
     * @values Yume\Kama\Obi\HTTP\Routing\Routes
     */
    protected Routes $routes;
    
    protected String $path;
    
    public function __construct()
    {
        // Create new Route Collection.
        AoE\Runtime::$app->object->routes = $this->routes = new Routes;
        
        // Get current route path.
        $this->path = HTTP\Server\Request::uri();
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Routing\RouterInterface
     *
     */
    public function create(): Void
    {
        // Import the file containing the route.
        AoE\Package::import( AoE\App::config( "http.routing.routes" ) );
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Routing\RouterInterface
     *
     */
    public function dispatch(): Void
    {
        if( $route = $this->validate( $this->routes ) )
        {
            var_dump( $route );
        } else {
            throw new RouteError( $this->path, RouteError::PAGE_NOT_FOUND );
        }
    }
    
    protected function validate( Routes $routes, ? String $parent = Null ): Array | Bool
    {
        foreach( $routes As $route )
        {
            // Get route regular expression.
            $regexp = $route->getRegExp();
            
            // Add a parent regular expression at the beginning (if the route has a parent).
            $regexp = $parent !== Null ? f( "{}/{}", $parent, $regexp ) : $regexp;
            
            // Checks if the current route path matches the current uri request.
            if( $result = RegExp\RegExp::match( $pattern = f( "/^(?:(?<path>({})))$/U", RegExp\RegExp::replace( "/\//", $regexp, "\x5c\x2f" ) ), $this->path ) )
            {
                return([
                    "route" => $route, 
                    "pattern" => $pattern, 
                    "matches" => RegExp\RegExp::clear( $result, True ) 
                ]);
            } else {
                
                // Check if the route has child routes.
                if( $childs = $route->getChild() )
                {
                    // If the child route has a match.
                    if( $revali = $this->validate( $childs, $regexp ) )
                    {
                        return( $revali );
                    }
                }
            }
            
        }
        return( False );
    }
    
}

?>