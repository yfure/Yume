<?php

namespace Yume\Kama\Obi\HTTP\Route;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflection;

class RouteGroup
{
    
    public Route $parent;
    
    public AoE\Data $routes;
    
    public function __construct( Route $parent )
    {
        $this->parent = $parent;
        $this->routes = new AoE\Data;
    }
    
    public function add( Array | String $method, String $path, Array | String | Callable $handler, ? Callable $group = Null ): Route
    {
        
        // If first path is slash.
        if( substr( $path, 0, 1 ) === "/" )
        {
            $path = substr( $path, 1, strlen( $path ) -1 );
        }
        
        $path = "{$this->parent->path()}/$path";
        
        if( $this->exists( $path ) )
        {
            throw new HTTP\HTTPException( __CLASS__, "Unable to define same page route." );
        } else {
            if( $path === HTTP\Route::NOTFOUND )
            {
                $route = $this->routes[ HTTP\Route::NOTFOUND ] = HTTP\Route::add( $method, "{$this->parent->path}/*", $handler );
            } else {
                $route = $this->routes[] = HTTP\Route::add( $method, $path, $handler, $group );
            }
        }
        return( $route );
    }
    
    public function exists( String $path ): Bool
    {
        if( str_replace( "\s", "", $path ) !== "" )
        {
            return( $this->routes->offsetExists( $path ) );
        } else {
            throw new HttpException( __CLASS__, "The route path cannot be empty." );
        }
    }
    
}

?>