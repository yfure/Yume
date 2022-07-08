<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflector;
use Yume\Kama\Obi\RegExp;
use Yume\Kama\Obi\Trouble;

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
    
    /*
     * Current request uri.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $path;
    
    /*
     * Construct method of class Route
     *
     * @access Public Instance
     *
     * @return Void
     */
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
        // Get the route that matches the current uri request.
        if( $result = $this->validate( $this->routes ) )
        {
            // Extract array to variable.
            extract( $result );
            
            // Check if server request method is allowed.
            if( HTTP\Server\Request::method( $route->getMethod() ) )
            {
                // Mapping route headers.
                array_map( array: $route->getHeader(), callback: fn( $args ) => HTTP\HTTP::header( $args['header'], $args['replace'], $args['code'] ) );
                
                // ....
                $execute = match( $type = ucfirst( [ $type = gettype( $handler = $route->getHandler() ) ][0] === "object" ? ( is_callable( $route->getHandler() ) ? "callable" : "object" ) : $type ) )
                {
                    // ....
                    "Array" => $this->handleController( $route, $matches, $handler[0], isset( $handler[1] ) ? $handler[1] : Null ),
                    
                    // ...
                    "Object" => $this->handleController( $route, $matches, $handler ),
                    
                    // ...
                    "String" => $this->handleString( $route, $matches, $handler ),
                    
                    // ...
                    "Callable" => $this->handleCallable( $route, $matches, $handler )
                };
                
                if( $execute !== Null )
                {
                    echo $execute;
                }
                exit;
            }
            throw new RouteError( $this->path, RouteError::METHOD_NOT_ALLOWED );
        }
        throw new RouteError( $this->path, RouteError::PAGE_NOT_FOUND );
    }
    
    final protected function handleController( Route $route, Array $matches, Object | String $handler, ? String $method = Null ): Void
    {
        // ....
        $reflect = Reflector\Kurasu::reflect( $handler );
        
        if( $reflect->implementsInterface( HTTP\Controller\ControllerInterface::class ) )
        {
            // ....
            var_dump( RegExp\RegExp::replace( "#" . BASE_PATH . "#", get_included_files(), "" ) );
        } else {
            // ....
        }
    }
    
    final protected function handleCallable( Route $route, Array $matches, Callable $handler ): Void
    {
        // ....
        $reflect = Reflector\ReflectFunction::reflect( $handler );
        
        
    }
    
    final protected function handleString( Route $route, Array $matches, String $handler ): Void
    {
        if( $matches = RegExp\RegExp::match( "/^(?:(?<Controller>Yume\\\Kama\\\App\\\HTTP\\\Controllers\\\[a-zA-Z_\x80-\xff][a-zA-Z0-9_\\\\x80-\xff]*[a-zA-Z0-9_\x80-\xff])|(?<View>view\.[a-zA-Z_\x80-\xff][a-zA-Z0-9-_\.\x80-\xff]*[a-zA-Z0-9_\x80-\xff]))$/i", $handler, True ) )
        {
            // Extract array to variable.
            extract( $matches );
            
            if( isset( $View ) )
            {
                // ...
            } else {
                $this->handleController( $route, $matches, $Controller );
            }
        }
    }
    
    /*
     * Validate whole route with current request.
     *
     * @access Protected
     *
     * @params Yume\Kama\Obi\HTTP\Routing\Routes $routes
     * @params String $parent
     *
     * @return Array|Bool
     */
    final protected function validate( Routes $routes, ? String $parent = Null ): Array | Bool
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