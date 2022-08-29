<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;
use Yume\Fure\View;

/*
 * SyntaxBranch
 *
 * @extends Yume\Fure\View\Template\TemplateSyntax
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxBranch extends View\Template\TemplateSyntax
{
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntax
     *
     */
    protected ? String $regexp = "/^(?:(?<syntax>(?<indent>[\s\t]*)\@(?<token>each|empty|for|if|isset|while)(?<spaces>[\r\t\n\s]+)(?<params>[^\:]*)\:(?<statmt>.*?)(?<suffix>\n\k{indent})\@endl(?<invalidSyntax>[^\n]*)))/ims";
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntax
     *
     */
    protected function handler( AoE\Data $match, Callable $self ): String
    {
        // Check if parameter is empty.
        if( $this->valueIsEmpty( $match->params ) === False )
        {
            // Get function cover.
            $match->endl = match( $token = strtolower( $match->token ) )
            {
                // Foreach-Loop syntax.
                "each" => "endforeach",
                
                // For-Loop syntax.
                "for" => "endfor",
                
                // If, If-Empty, If-Isset syntax
                "if",
                "empty",
                "isset" => "endif",
                
                // While-Loop syntax.
                "while" => "endwhile"
            };
            
            // If token name is "if".
            if( $match->token === "if" )
            {
                // Get function indent.
                $indent = $match->indent ? f( str_replace( "\x20", "\\s", $match->indent ) ) : "";
                
                // Regular expression to capture "else" and "elif" syntax.
                $regexp = "/^(?:(?<syntax>(?<indent>{})\@(?<token>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)(?<spaces>[\r\t\n\s]*)(?<params>[^\:]*)\:))/ms";
                
                // Search for "else" and "elif" syntax by indentation.
                $match->statmt = RegExp\RegExp::replace( f( $regexp, $indent ), $match->statmt, function( Array | AoE\Data $rmatch )
                {
                    // Statically variable.
                    static $iterate = 0;
                    
                    // Create data object.
                    $rmatch = new AoE\Data( $rmatch );
                    
                    switch( $rmatch->token )
                    {
                        // Else if syntax handle.
                        case "elif":
                        case "empty":
                        case "isset":
                            
                            // If "elif" parameter is empty.
                            if( $this->valueIsEmpty( $rmatch->params ) )
                            {
                                // Invalid syntax branch if!
                            } else {
                                
                                // Create inline syntax.
                                $syntax = match( $rmatch->token )
                                {
                                    "elif" => "else if( { params } )",
                                    "empty" => "else if( empty( { params } ) )",
                                    "isset" => "else if( isset( { params } ) )"
                                };
                            }
                            break;
                            
                        // Else handle.
                        case "else":
                            
                            // If there is no duplicate "else" in one branch.
                            if( $iterate < 1 )
                            {
                                // If "else" parameter is empty.
                                if( $this->valueIsEmpty( $rmatch->params ) )
                                {
                                    $syntax = "else";
                                    $iterate++;
                                } else {
                                    // Invalid syntax branch else!
                                }
                            } else {
                                // Invalid syntax branch else!
                            }
                            break;
                        
                        default:
                            $syntax = f( "Invalid syntax { token }", $rmatch ); break;
                    }
                    
                    // Inline syntax.
                    $rmatch->inline = f( $syntax, $rmatch );
                    
                    // Return result scheme.
                    return( f( "{ indent }<?php { inline }: ?>", $rmatch ) );
                });
            }
            
            // Re-parse the function statement.
            $match->statmt = View\Template\TemplateReflector::compile( $this->view, $match->statmt );
            
            // Create inline code.
            $match->inline = f( $token === "each" ? "foreach( { params } )" : ( $token === "empty" ? "if( empty( { params } ) )" : ( $token === "isset" ? "if( isset( { params } ) )" : "{ token }( { params } )" ) ), $match );
            
            // Return result scheme.
            return( f( "{ indent }<?php { inline }: ?>{ statmt }{ suffix }<?php { endl }; ?>", $match ) );
        }
        
        // Invalid syntax branch!
    }
    
}

?>