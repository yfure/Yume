<?php

namespace Yume\Fure\View\Template;

use Yume\Fure\Reflector;
use Yume\Fure\RegExp;
use Yume\Fure\View;

/*
 * TemplateReflector
 *
 * @package Yume\Fure\View\Template\TemplateReflector
 */
abstract class TemplateReflector
{
    
    /*
     * Compile view template content.
     *
     * @access Public Static
     *
     * @params String $view
     * @params String $content
     *
     * @return String
     */
    public static function compile( String $view, String $content ): String
    {
        // Replace all tabs with spaces.
        $content = RegExp\RegExp::replace( "/\t/", $content, "\x20\x20\x20\x20" );
        
        // Get the whole parser class.
        $parsers = View\View::config( "template.parsers" );
        
        // Mapping parsers.
        array_map( array: $parsers, callback: function( String $parser ) use( $view, &$content )
        {
            // Compile view template content.
            $content = Reflector\ReflectClass::instance( $parser, [ $view, $content ] )->parse( fn( String $view, String $content ) => self::compile( $view, $content ) );
        });
        
        return( $content );
    }
    
    /*
     * Validate the compiled view file.
     *
     * @access Public Static
     *
     * @params String $view
     * @params String $content
     *
     * @return Void
     */
    public static function validate( String $view, String $content ): Void
    {
        // Regular expression to catch syntax error code.
        $regexp = "/(?:(?<inline>\@((?<token>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)|(?<syntax>\S+))))/";
        
        // Splitting a string with a newline.
        $flines = explode( "\n", $content );
        
        // Mapping file lines.
        array_map( array: $flines, callback: function( $line ) use( $view, $regexp )
        {
            // The line of code always starts at 1.
            static $iter = 1;
            
            // Check if there is an invalid syntax.
            if( $match = RegExp\RegExp::match( $regexp, $line ) )
            {
                // Get position code.
                $posit = strpos( $line, $match['inline'] );
                
                // Get filename.
                $file = View\View::format( $view );
                
                // If there is an error token.
                if( $match['token'] )
                {
                    throw new TemplateSyntaxTokenError( f( "SyntaxTokenError: Unexpected token \"{}\" in file {} on line {} at position {}.", $match['token'], $file, $iter, $posit ) );
                }
                throw new TemplateSyntaxError( f( "SyntaxError: Invalid syntax \"{}\" in file {} on line {} at position {}.", $match['syntax'], $file, $iter, $posit ) );
            }
            $iter++;
        });
    }
    
}

?>