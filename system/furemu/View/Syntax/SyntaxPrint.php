<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;
use Yume\Fure\View;

/*
 * SyntaxPrint
 *
 * @extends Yume\Fure\View\Template\TemplateSyntax
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxPrint extends View\Template\TemplateSyntax
{
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntax
     *
     */
    protected ? String $regexp = "/(?:(?<syntax>\@((?<token>echo|html|print)(\:(?<named>\S+))*[\r\t\n\s]+(?<value>[^\;]*)\;|(?<anonym>(\:(?<named>\S+))*\{[\r\t\n\s]*(?<value>.*?)[\r\t\n\s]*\}\;))))/isJ";
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntax
     *
     */
    protected function handler( AoE\Data $match, Callable $self ): String
    {
        // If the output value is empty.
        if( $this->valueIsEmpty( $match->value ) )
        {
            // Invalid syntax printer.
            return( "" );
        } else {
            
            // Token selection.
            $match->token = $match->token === Null || $match->token === False ? "echo" : $match->token;
            
            // If the type name is not defined.
            if( $this->valueIsEmpty( $match->named ) )
            {
                // Add function convert value to string.
                $match->value = f( "Yume\Fure\AoE\Stringer::parse( { value } )", $match );
            } else {
                
                // Check if the type name is valid.
                if( RegExp\RegExp::test( "/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\\\\x80-\xff]*[a-zA-Z0-9_\x80-\xff]$/", $match->named ) )
                {
                    // If type is not string.
                    if( strtolower( $match->named ) !== "string" )
                    {
                        // Add function convert value to string.
                        $match->value = f( "Yume\Fure\AoE\Stringer::parse( { value } )", $match );
                    }
                } else {
                    // Invalid syntax printer.
                }
            }
            
            // If the output is pure html.
            if( $match->token === "html" )
            {
                // Return syntax scheme.
                return( f( "<?php echo { value }; ?>", $match ) );
            }
            
            // Return syntax scheme.
            return( f( "<?php { token } htmlspecialchars( { value } ); ?>", $match ) );
        }
    }
}

?>