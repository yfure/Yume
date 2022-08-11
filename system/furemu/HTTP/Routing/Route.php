<?php

namespace Yume\Fure\HTTP\Routing;

use Yume\Fure\AoE;
use Yume\Fure\Error;
use Yume\Fure\RegExp;
use Yume\Fure\Threader;

use UnhandledMatchError;

/*
 * Route
 *
 * @package Yume\Fure\HTTP\Routing
 */
class Route implements RouteInterface
{
    
    /*
     * List of route headers.
     *
     * The header will only be sent before
     * the controller/view is executed.
     *
     * @access Protected
     *
     * @values Array
     */
    protected Array $headers = [];
    
    /*
     * Route meta type.
     *
     * @access Protected
     *
     * @values Int
     */
    protected Int $meta = RouteAbstract::ANY;
    
    /*
     * Route name.
     *
     * @access Protected
     *
     * @values String
     */
    protected ? String $name = Null;
    
    /*
     * Regular expression.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $regexp = "";
    
    /*
     * Segment route pattern based on segment name.
     *
     * @access Protected
     *
     * @values Array
     */
    protected Array $segments = [];
    
    /*
     * Construct method of class Route
     *
     * @access Public Instance
     *
     * @params String $method
     * @params String $path
     * @params Array|String|Callback $handler
     * @params Routes|Null $children
     *
     * @return Void
     */
    public function __construct( protected String $method, protected String $path, protected Mixed $handler, protected ? Routes $children = Null )
    {
        // Validate method name.
        array_map( array: explode( "|", $method ), callback: function( $name )
        {
            // If the method name is not available.
            if( in_array( $name, $methods = Threader\App::config( "http.request.methods" ) ) === False )
            {
                throw new Error\TypeError( f( "The \$method parameter must have the value /{}/, {} given.", implode( "|", $methods ), $name ) );
            }
        });
        
        // Checks if the handler value matches.
        if( RegExp\RegExp::test( "/(?:\b(Array|String|Object|Callable)\b)/i", gettype( $handler ) ) === False )
        {
            throw new Error\TypeError( f( "The \$handler parameter must have a value of type /Array|String|Object|Callable/i, {} is given.", gettype( $handler ) ) );
        }
        
        // Create regular expression for route.
        $this->regexp = RegExp\RegExp::replace( Threader\App::config( "http.routing.regexp.segment" ), $path, fn( $match ) => $this->replace( $match ) );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getChild(): ? Routes
    {
        return( $this->children );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getHandler(): Array | Object | String | Callable
    {
        return( $this->handler );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getHeader(): Array
    {
        return( $this->headers );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getMeta(): Int
    {
        return( $this->meta );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getMethod(): String
    {
        return( $this->method );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getName(): ? String
    {
        return( $this->name );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getPath(): String
    {
        return( $this->path );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getRegExp(): String
    {
        return( $this->regexp );
    }
    
    /*
     * @inherit Yume\Fure\HTTP\Routing\RouteInterface
     *
     */
    public function getSegment(): Array
    {
        return( $this->segments );
    }
    
    /*
     * Change or give route name.
     *
     * @access Public
     *
     * @params String $name
     *
     * @return Static
     */
    final public function name( String $name ): Static
    {
        if( $name !== "" )
        {
            $this->name = $name;
        }
        return( $this );
    }
    
    /*
     * Change the value of the regular expression on the segment.
     *
     * @access Public
     *
     * @params String $segment
     * @params String $regexp
     *
     * @return Static
     */
    final public function where( String $segment, String $regexp ): Static
    {
        // Check if the segment exists.
        if( isset( $this->segments[$segment] ) )
        {
            // Check if the segment can be changed.
            if( $this->segments[$segment]['--x-rw'] )
            {
                // Change segment value.
                $this->segments[$segment]['regexp'] = $regexp;
                
                // Replace regular expression with new expression.
                $this->regexp = RegExp\RegExp::replace( $p = f( "/(?:(?<Group>\({1,}\?\<{segment}\>\([^\)]*\){1,})|(?<Single>\(\?\<{segment}\>[^\)]*\)))/", [ "segment" => $segment ] ), $this->regexp, fn( $m ) => f( "(?<{}>{})", $segment, $regexp ) );
            } else {
                throw new RouteError( [ $segment, $this->path ], RouteError::SEGMENT_READONLY );
            }
        } else {
            throw new RouteError( [ $this->path, $segment ], RouteError::SEGMENT_NAME_ERROR );
        }
        return( $this );
    }
    
    /*
     * Set header for route.
     *
     * @access Public
     *
     * @params String $header
     * @params Bool $replace
     * @params Int $code
     *
     * @return Static
     */
    final public function header( String $header, Bool $replace = True, Int $code = 0 ): Static
    {
        // Push header.
        $this->headers[] = [
            "replace" => $replace,
            "header" => $header,
            "code" => $code
        ];
        return( $this );
    }
    
    /*
     * Add or change route meta.
     *
     * @access Public
     *
     * @params String|Int $type
     *
     * @return Static
     */
    final public function meta( Int | String $type = RouteAbstract::ANY ): Static
    {
        try {
            $this->meta = match( is_string( $type ) ? strtolower( $type ) : $type )
            {
                // Shorthand mode.
                "any" => RouteAbstract::ANY,
                "auth" => RouteAbstract::AUTH,
                "guest" => RouteAbstract::GUEST,
                
                // Longhand mode.
                RouteAbstract::ANY,
                RouteAbstract::AUTH,
                RouteAbstract::GUEST => $type
            };
        }
        catch( UnhandledMatchError $e )
        {
            throw new RouteError( [ $type, $this->path ], RouteError::UNHANDLED_META_TYPE, $e );
        }
        return( $this );
    }
    
    /*
     * Replace route to regular expression.
     *
     * @access Protected
     *
     * @params Array $match
     *
     * @return String
     */
    final protected function replace( Array $match )
    {
        // Clean up match results.
        $match = RegExp\RegExp::clear( $match, True );
        
        // Regular expression.
        $regexp = "";
        
        if( isset( $match['SegmentName'] ) )
        {
            // Please note that the segment with the name /params/ is only used for <SegmentMatchAll>
            if( $match['SegmentName'] === "params" )
            {
                throw new RouteError( $this->path, RouteError::SEGMENT_NAME_PROHIBITED );
            }
            
            // If there is a duplication of the name of the SubPattern.
            if( isset( $this->segments[$match['SegmentName']] ) )
            {
                throw new RouteError( [ $this->path, $match['Segment'] ], RouteError::SEGMENT_NAME_DUPLICATE );
            }
            
            // Register pattern.
            $this->segments[$match['SegmentName']] = [
                
                /*
                 * Readable
                 *
                 * Give permission allowed to rewrite, remember if the
                 * segment does not have a pattern then the segment
                 * is allowed to be rewritten, but if the segment
                 * has a default pattern then the segment should
                 * not be replaced or read only.
                 *
                 * @values Bool
                 */
                "--x-rw" => isset( $match['SegmentRegExp'] ) ? False : True,
                
                /*
                 * If the segment does not have a pattern it will
                 * be replaced with the default pattern.
                 *
                 * @see configs/app.http.routing.regexp.default
                 */
                "regexp" => isset( $match['SegmentRegExp'] ) ? $match['SegmentRegExp'] : ( ( $regexp = RouteSegment::get( $match['SegmentName'] ) ) ? $regexp : RouteSegment::get( "default" ) )
                
            ];
            
            // Change regexp.
            $regexp = f( "(?<{}>{})", $match['SegmentName'], $this->segments[$match['SegmentName']]['regexp'] );
        } else {
            if( isset( $match['SegmentMatchAll'] ) )
            {
                // If SegmentMatchAll is more than one.
                if( isset( $this->segments['params'] ) )
                {
                    throw new RouteError( $this->path, RouteError::THERE_ARE_MANY_PARAMS_SEGMENTS );
                }
                
                // Register pattern.
                $this->segments['params'] = [
                    
                    // Make Unreadable.
                    "--x-rw" => False,
                    
                    // Expression value.
                    "regexp" => $match['SegmentMatchAll']
                    
                ];
                
                // Change regexp.
                $regexp = f( "(?<params>{})", $match['SegmentMatchAll'] );
            }
        }
        
        // Return as expression.
        return( $regexp );
    }
    
}

?>