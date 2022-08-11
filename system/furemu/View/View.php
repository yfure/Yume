<?php

namespace Yume\Fure\View;

use Yume\Fure\AoE;
use Yume\Fure\IO;
use Yume\Fure\RegExp;

use Stringable;
use Throwable;

/*
 * View
 *
 * @package Yume\Fure\View
 */
class View implements Stringable
{
    
    /*
     * View file name.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $path;
    
    /*
     * View file contents.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $view;
    
    /*
     * View data.
     *
     * @access Protected
     *
     * @values Object
     */
    protected Object $data;
    
    protected Array $parser = [];
    
    use AoE\ITraits\Config;
    
    /*
     * Construct method of class View.
     *
     * @access Public Instance
     *
     * @params String $path
     * @params Array $data
     *
     * @return Void
     */
    public function __construct( String $path, Array $data = [] )
    {
        if( $data Instanceof AoE\Data === False )
        {
            $data = new AoE\Data( $data );
        }
        $this->data = $data;
        $this->path = $path;
        try {
            $this->view = IO\File::read( f( View::config( "save.path" ), $path ) );
        }
        catch( IO\IOError $e )
        {
            throw new ViewError( $e->getMessage(), 0, $e );
        }
        if( IO\File::exists( View::config( "cache.parsed" ), $this->path ) )
        {
            $viewLoadedCacheSize = IO\File::size( f( View::config( "cache.loaded" ), $this->path ) );
            $viewLoadesSize = IO\File::size( f( View::config( "save.path" ), $this->path ) );
            
            if( $viewLoadedCacheSize !== $viewLoadesSize )
            {
                $this->parse();
            }
        } else {
            $this->parse();
        }
    }
    
    public function execute(): Mixed
    {
        // ...
        ob_start();
        
        try {
            
            // ...
            include( path( f( View::config( "cache.parsed" ), $this->path ) ) );
        }
        catch( Throwable $e )
        {
            // ...
            ob_clean();
            
            // ...
            throw new ViewError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
        
        // ...
        return( str_replace( [ "\t", "\n" ], "", ob_get_clean() ) );
    }
    
    public function getParsed(): String
    {
        return( $this->parsed );
    }
    
    public function __toString(): String
    {
        return( $this->execute() );
    }
    
    protected function parse(): Void
    {
        // ...
        $loaded = f( View::config( "cache.loaded" ), $this->path );
        $parsed = f( View::config( "cache.parsed" ), $this->path );
        
        // ...
        if( IO\Path::exists( AoE\Stringer::pop( $parsed, "/" ) ) === False )
        {
            IO\Path::mkdir( AoE\Stringer::pop( $parsed, "/" ) );
        }
        
        // ...
        IO\File::write( $loaded, $this->view );
        IO\File::write( $parsed, $this->parsed = $this->parser( $this->view ) );
    }
    
    protected function parser( String $content ): String
    {
        // Replace tabs as spaces.
        $parsed = str_replace( "\t", "\x20\x20\x20\x20", $content );
        $regexp = [
            [
                "indent" => True,
                "regexp" => implode( "", [
                    "/^(?:(?<doWhile>",
                        "(?<indent>(\s|\t){0,})",
                        "\@(?<token>(do)\b)(?<opening>\:)(?<invalid>[^\n]*)",
                            "(?<state>(\n\k{indent}(\s{2,4,}|\t{1,})[^\n]*){0,})",
                        "(?<end>(\n\k{indent})*)",
                        "\@(?<while>while\b([\s|\t]*)(?<params>[^\:]*)(?<closing>\:)(?<wInvalid>[^\n]*))",
                    "))$/ms"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    // Re-parse the statement.
                    $match->state = $this->parser( $match->state );
                    
                    // Return parsed value.
                    return( f( "{indent}<?php do { ?>{state}\n{indent}<?php } while( {params} ); ?>", [
                        "indent" => $match->indent,
                        "params" => $match->params,
                        "state" => $match->state,
                    ]));
                }
            ],
            [
                "indent" => True,
                "regexp" => implode( "", [
                    "/^(?:(?<syntax>",
                        "(?<indent>(\s|\t){0,})",
                        "\@(?<token>(if|for|foreach|match|while)\b)([\s|\t]*)(?<params>[^\:]*)(?<opening>\:)(?<invalid>[^\n]*)",
                            "(?<state>(\n\k{indent}(\s{2,4,}|\t{1,})[^\n]*){0,})",
                        "(?<end>(\n\k{indent})*)",
                    "))$/ms"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    // Re-parse the statement.
                    $match->state = $this->parser( $match->state );
                    
                    // The suffix for match blocks.
                    $match->point = "";
                    
                    // If token name is "match"
                    if( $match->token === "match" )
                    {
                        $match->point = ";";
                        $match->token = "echo match";
                    }
                    
                    // Return parsed value.
                    return( f( "{indent}<?php {token}( {params} ) { ?>{state}\n{indent}<?php }{point} ?>{end}", [
                        "indent" => $match->indent,
                        "params" => $match->params,
                        "token" => $match->token,
                        "state" => $match->state,
                        "point" => $match->point,
                        "end" => $match->end
                    ]));
                }
            ]
        ];
        /*
        // Mapping regexp.
        array_map( array: $regexp, callback: function( $per ) use( &$parsed )
        {
            // Parse view per regexp.
            $parsed = RegExp\RegExp::replace( $per['regexp'], $parsed, function( Array $match ) use( $per )
            {
                return( $per['handler']( new AoE\Data( RegExp\RegExp::clear( $match, True ) ) ) );
            });    
        });
        */
        // Mapping syntax.
        array_map( array: View::config( "parsers" ), callback: function( $parser ) use( &$parsed )
        {
            // ...
            $this->parser[$parser] = new $parser( fn( String $params ) => $this->parser( $params ), $parsed, $this->path );
            
            // ...
            $parsed = $this->parser[$parser]->render();
        });
        
        return( $parsed );
    }
    
}

?>