<?php

namespace Yume\Fure\View\Tokenizer;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;

use Closure;

/*
 * Tokenizer
 *
 * @package Yume\Fure\View\Tokenizer
 */
abstract class Tokenizer implements TokenizerInterface
{
    
    /*
     * Regular expression syntax.
     *
     * @access Protected
     *
     * @values Array|String
     */
    protected Array | String $regexp;
    
    use AoE\ITraits\Overloader\Closure;
    
    /*
     * @inherit Yume\Fure\View\TokenizerInterface
     *
     */
    public function __construct( protected Closure $parser, protected String $content, protected String $view ) {}
    
    /*
     * @inherit Yume\Fure\View\TokenizerInterface
     *
     */
    public function render(): String
    {
        // ...
        $content = $this->content;
        
        // If tokenizer has multiple pattern.
        if( is_array( $this->regexp ) )
        {
            // Mapping regexp.
            array_map( array: $this->regexp, callback: function( $regexp ) use( &$content )
            {
                // ...
                if( is_array( $regexp['pattern'] ) )
                {
                    $regexp['pattern'] = implode( "", $regexp['pattern'] );
                }
                $content = RegExp\RegExp::replace( $regexp['pattern'], $content, function( Array $match ) use( $regexp )
                {
                    return( $regexp['handler']( new AoE\Data( RegExp\RegExp::clear( $match, True ) ) ) );
                });
            });
            
            // Return replaced content.
            return( $content );
        }
        
        // Returns the value of the content replaced with a single regex.
        $result = RegExp\RegExp::replace( $this->regexp, $content, function( Array $match )
        {
            // ....
            return( $this->handler( new AoE\Data( RegExp\RegExp::clear( $match, True ) ) ) );
        });
        
        return( $result );
    }
    
    public function clearer( String $text ): String
    {
        return( RegExp\RegExp::replace( "/(^[\s]+])|([\s]+$)/", str_replace( [ "\n", "\t", "    ", "  ", "  ", "  " ], [ "", " " ], $text ), "" ) );
    }
    
    public function htmlable( String $text ): String
    {
        return( RegExp\Regexp::replace( "/^(?<indent>[\s]*)(?<value>\<[^\n]*)/m", $text, function( Array $m )
        {
            return( f( "{0}echo \"{1}\";", $m['indent'], str_replace( "\"", "\\\"", $m['value'] ) ) );
        }));
    }
    
    public function isNoneOrWhiteSpace( ? String $text ): Bool
    {
        return( $text === "" || $text === Null || $text === False ? True : RegExp\RegExp::test( "/^[\s]+$/ms", $text ) );
    }
    
    /*
     * Template replacement handler.
     *
     * @access Protected
     *
     * @params Yume\Fure\AoE\Data $match
     *
     * @return String
     */
    abstract protected function handler( AoE\Data $match ): ? String;
    
}

?>