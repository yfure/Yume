<?php

namespace Yume\Kama\Obi\HTTP\Route;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflection;

/*
 * Route utility class.
 *
 * @package Yume\Kama\Obi\HTTP\Route
 */
class Route
{
    
    /*
     * Route path name.
     *
     * @access Private
     *
     * @values String
     */
    private $path;
    
    /*
     * Route meta.
     *
     * @access Private
     *
     * @values Int
     */
    private $meta;
    
    /*
     * RouteGroup instancle class.
     *
     * @access Private
     *
     * @values Yume\Kama\Obi\HTTP\Route\RouteGroup
     */
    private $group;
    
    /*
     * Search segment route.
     *
     * @access Private
     *
     * @values Array
     */
    private $where = [];
    
    /*
     * Route method.
     *
     * @access Private
     *
     * @values Array, String
     */
    private $method;
    
    /*
     * Route parent path name.
     *
     * @access Private
     *
     * @values String
     */
    private $parent;
    
    /*
     * Route parent params.
     *
     * @access Private
     *
     * @values Array
     */
    private $params = [];
    
    /*
     * Route handler.
     *
     * @access Private
     *
     * @values Array, String, Callable
     */
    private $handler;
    
    /*
     * Route segment pattern.
     *
     * @access Private
     *
     * @values Array, String
     */
    private $pattern;
    
    /*
     * Route segment matched.
     *
     * @access Private
     *
     * @values Null, Array
     */
    private $segment = [];
    
    /*
     * Rute headers.
     *
     * @access Private
     *
     * @values Array
     */
    private $headers = [];
    
    /*
     * Route content type response.
     *
     * @access Private
     *
     * @values String
     */
    private $response;
    
    /*
     * Route redirect page.
     *
     * @access Private
     *
     * @values String
     */
    private $redirect;
    
    /*
     * Route instansce class.
     *
     * @access Public
     *
     * @return Static
     */
    public function __construct( Array $args = [] )
    {
        foreach( $args As $prop => $value )
        {
            $this->{ $prop } = $value;
        }
        if( is_callable( $this->group ) )
        {
            Reflection\ReflectionFunction::invoke( $args['group'], [ $this->group = new RouteGroup( $this ) ] );
        }
    }
    
    /*
     * Get or Set route path.
     *
     * @access Public
     *
     * @return String, Static
     */
    public function path(): String | Static | Null
    {
        if( isset( func_get_args()[0] ) )
        {
            $this->path = func_get_args()[0];
        } else {
            return( $this->path );
        }
        return( $this );
    }
    
    /*
     * Set route meta.
     *
     * @access Public
     *
     * @params Int <meta>
     *
     * @return Static
     */
    public function meta( ? Int $meta = Null ): Int | Null | Static
    {
        if( $meta !== Null )
        {
            if( $meta === HTTP\Route::AUTH || $meta === HTTP\Route::GUEST || $meta === HTTP\Route::ALLOW )
            {
                $this->meta = ( Int ) $meta;
            } else {
                throw new Trouble\Exception\HTTPRouteError( "Invalid meta route, on route >> {$this->path}" );
            }
        } else {
            return( $this->meta );
        }
        return( $this );
    }
    
    /*
     * Return route group.
     *
     * @access Public
     *
     * @return Yume\Kama\Obi\HTTP\Route\RouteGroup, Null
     */
    public function group(): ? RouteGroup
    {
        return( $this->group );
    }
    
    /*
     * Get or Set where segment search.
     *
     * @access Public
     *
     * @params String, Null <key>
     * @params String, Null <val>
     *
     * @return Array, Static
     */
    public function where( ? String $key = Null, ? String $val = Null ): Array | Static
    {
        if( $key !== Null && $val !== Null )
        {
            $this->where[$key] = $val;
        } else {
            return( $this->where );
        }
        return( $this );
    }
    
    /*
     * Return route method.
     *
     * @access Public
     *
     * @return Array, String
     */
    public function method(): Array | String
    {
        return( $this->method );
    }
    
    /*
     * Return route parent.
     *
     * @access Public
     *
     * @return String, Null
     */
    public function parent(): ? String
    {
        return( $this->parent );
    }
    
    public function params()
    {
        if( count( $params = func_get_args() ) !== 0 )
        {
            $this->params = $params[0];
        } else {
            return( $this->params );
        }
        return( $this );
    }
    
    /*
     * Return route handler.
     *
     * @access Public
     *
     * @return Array, String, Callable
     */
    public function handler(): Array | String | Callable
    {
        return( $this->handler );
    }
    
    public function pattern()
    {
        if( count( $params = func_get_args() ) !== 0 )
        {
            $this->pattern = $params[0];
        } else {
            return( $this->pattern );
        }
        return( $this );
    }
    
    /*
     * Get or Set route segment.
     *
     * @access Private
     *
     * @params Array, Null <segment>
     *
     * @return Array, Static
     */
    public function segment( ? Array $segment = Null ): Array | Static
    {
        if( $segment !== Null )
        {
            $this->segment = $segment;
        } else {
            return( $this->segment );
        }
        return( $this );
    }
    
    /*
     * Get or Set route headers.
     *
     * @access Public
     *
     * @params Array, String <header>
     * @params Bool <replace>
     * @params Int <status>
     *
     * @return Static
     */
    public function header( Array | Null | String $header = Null, Bool $replace = True, Int $code = 0 ): Array | Static
    {
        if( $header !== Null )
        {
            if( is_array( $header ) )
            {
                foreach( $header As $group )
                {
                    if( count( $group ) !== 0 )
                    {
                        $this->headers[] = [ $group[0], isset( $group[1] ) ? $group[1] : True, isset( $group[2] ) ? $group[2] : 0 ];
                    }
                }
            } else {
                $this->headers[] = [ $header, $replace, $code ];
            }
        } else {
            return( $this->headers );
        }
        return( $this );
    }
    
    /*
     * Get or Set route response content type.
     *
     * @access Public
     *
     * @params String, Null <type>
     *
     * @return String, Static, Null
     */
    public function response( ? String $type = Null ): String | Static | Null
    {
        if( $type !== Null )
        {
            if( $type === "" )
            {
                throw new Trouble\Exception\HTTPRouteError( "Invalid response route, on route >> {$this->path}" );
            } else {
                if( $this->group !== Null && $this->group->routes->count() !== 0 )
                {
                    foreach( $this->group->routes As $i )
                    {
                        $this->group->routes->current()->response( $type );
                    }
                }
                $this->response = $type;
            }
        } else {
            return( $this->response );
        }
        return( $this );
    }
    
    /*
     * Route redirect.
     *
     * @access Public
     *
     * @params String, Null <target>
     *
     * @return String, Static, Null
     */
    public function redirect( ? String $target = Null ): String | Static | Null
    {
        if( $target !== Null )
        {
            $this->redirect = $target;
        } else {
            return( $this->redirect );
        }
        return( $this );
    }
    
}

?>