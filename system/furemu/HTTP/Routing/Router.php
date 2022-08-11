<?php

namespace Yume\Fure\HTTP\Routing;

use Yume\Fure\AoE;
use Yume\Fure\HTTP;
use Yume\Fure\Reflector;
use Yume\Fure\RegExp;
use Yume\Fure\Error;
use Yume\Fure\Threader;

/*
 * Router
 *
 * @package Yume\Fure\HTTP\Routing
 */
class Router implements RouterInterface
{
    
    /*
     * Routes class instance.
     *
     * @access Protected
     *
     * @values Yume\Fure\HTTP\Routing\Routes
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
        // Starting new session.
        //HTTP\Session\Session::start();
        
        // Create new Route Collection.
        Threader\Runtime::$app->object->routes = $this->routes = new Routes;
        
        // Get current route path.
        $this->path = HTTP\HTTPRequest::uri();
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouterInterface
     *
     */
    public function create(): Void
    {
        // Import the file containing the route.
        AoE\Package::import( Threader\App::config( "http.routing.routes" ) );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouterInterface
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
            if( HTTP\HTTPRequest::method( $route->getMethod() ) )
            {
                // Handle route meta.
                $this->handleMeta( $route );
                
                // Mapping route headers.
                array_map( array: $route->getHeader(), callback: fn( $args ) => HTTP\HTTP::header( $args['header'], $args['replace'], $args['code'] ) );
                
                // Get route handler.
                $handler = $route->getHandler();
                
                // Get route handler type.
                $type = gettype( $handler );
                
                // If type is is Object or Callable.
                if( $type === "object" )
                {
                    // If route handler is Callable.
                    if( is_callable( $handler ) )
                    {
                        $type = "Callable";
                    }
                }
                
                // Matching handler type.
                $execute = match( ucfirst( $type ) )
                {
                    "Array" => $this->handleController( $route, $matches, $handler[0], isset( $handler[1] ) ? $handler[1] : Null ),
                    "Object" => $this->handleController( $route, $matches, $handler ),
                    "String" => $this->handleString( $route, $matches, $handler ),
                    "Callable" => $this->handleCallable( $route, $matches, $handler )
                };
                
                // If handler returned value.
                if( is_string( $execute ) || is_int( $execute ) || is_array( $execute ) )
                {
                    // Display output values.
                    echo( AoE\Stringer::parse( $execute ) );
                }
                
                // Close the program.
                exit;
            }
            throw new RouteError( $this->path, RouteError::METHOD_NOT_ALLOWED );
        }
        throw new RouteError( $this->path, RouteError::PAGE_NOT_FOUND );
    }
    
    /*
     * Handle route meta.
     *
     * @access Protected
     *
     * @params Yume\Fure\HTTP\Routing\Route
     *
     * @return Void
     */
    final protected function handleMeta( Route $route ): Void
    {
        // ...
        $isAuth = HTTP\Authentication\Authentication::isAuth();
        
        switch( $route->getMeta() )
        {
            // ...
            case RouteAbstract::AUTH:
                
                // Check if user is authenticated.
                if( $isAuth !== True )
                {
                    // ...
                }
                break;
            
            // ...
            case RouteAbstract::GUEST:
                
                // Check if user is not authenticated.
                if( $isAuth !== False )
                {
                    // Error...
                }
                break;
        }
    }
    
    /*
     * Handle controller class.
     *
     * @access Protected
     *
     * @params Yume\Fure\HTTP\Routing\Route $route
     * @params Array $matches
     * @params Object|String $handler
     * @params String $method
     *
     * @return Mixed
     */
    final protected function handleController( Route $route, Array $matches, Object | String $handler, ? String $method = Null ): Mixed
    {
        // Reference Class Reflection.
        $reflect = Null;
        
        // Checks if Controller class implements Controller Interface.
        if( Reflector\ReflectClass::isImplements( $handler, HTTP\Controller\ControllerInterface::class, $reflect ) )
        {
            if( method_exists( $reflect->name, $method = $method !== Null ? $method : Threader\App::config( "http.controller[default.method]" ) ) )
            {
                return( Reflector\ReflectMethod::invoke( $reflect, $method, [ ...$matches, "route" => $route ] ) );
            }
            throw new HTTP\Controller\ControllerError( [ $reflect->name, $method ], HTTP\Controller\ControllerError::METHOD_ERROR );
        }
        throw new HTTP\Controller\ControllerError( $reflect->name, HTTP\Controller\ControllerError::IMPLEMENTS_ERROR );
    }
    
    /*
     * Handle handler route callable.
     *
     * @access Protected
     *
     * @params Yume\Fure\HTTP\Routing\Route $route
     * @params Array $matches
     * @params Callable $handler
     *
     * @return Mixed
     */
    final protected function handleCallable( Route $route, Array $matches, Callable $handler ): Mixed
    {
        return( Reflector\ReflectFunction::invoke( $handler, [ ...$matches, "route" => $route ] ) );
    }
    
    /*
     * Handle handler route string.
     *
     * @access Protected
     *
     * @params Yume\Fure\HTTP\Routing\Route $route
     * @params Array $matches
     * @params String $handler
     *
     * @return Mixed
     */
    final protected function handleString( Route $route, Array $matches, String $handler ): Mixed
    {
        // Controller namespace.
        $cname = "Yume\\\App\\\HTTP\\\Controllers";
        
        // Regular Expression.
        $regexp = "/^(?:(?<Controller>$cname\\\[a-zA-Z_\x80-\xff][a-zA-Z0-9_\\\\x80-\xff]*[a-zA-Z0-9_\x80-\xff])\:\:(?<Method>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)|(?<Controller>$cname\\\[a-zA-Z_\x80-\xff][a-zA-Z0-9_\\\\x80-\xff]*[a-zA-Z0-9_\x80-\xff])|view\.(?<View>[a-zA-Z_\x80-\xff][a-zA-Z0-9-_\.\x80-\xff]*[a-zA-Z0-9_\x80-\xff]))$/iJ";
        
        // Checks if string is ViewName or ControllerName.
        if( $capture = RegExp\RegExp::match( $regexp, $handler, True ) )
        {
            // Extract array to variable.
            extract( $capture = RegExp\RegExp::clear( $capture, True ) );
            
            // Return value.
            return( isset( $View ) ? $View : $this->handleController( $route, $matches, $Controller, isset( $Method ) ? $Method : Null ) );
        }
        throw new RouteError( $handler, RouteError::INVALID_HANDLER_STRING );
    }
    
    /*
     * Validate whole route with current request.
     *
     * @access Protected
     *
     * @params Yume\Fure\HTTP\Routing\Routes $routes
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
            if( $result = RegExp\RegExp::match( $pattern = f( "/^(?:({}))$/U", RegExp\RegExp::replace( "/\//", $regexp, "\x5c\x2f" ) ), $this->path ) )
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