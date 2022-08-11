<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\View;

use Closure;

/*
 * SyntaxMatching
 *
 * Handle matching syntax e.g switch, match
 *
 * @extends Yume\Fure\View\Tokenizer\Tokenizer
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxMatching extends View\Tokenizer\Tokenizer
{
    
    /*
     * @inherit Yume\Fure\View\TokenizerInterface
     *
     */
    public function __construct( protected Closure $parser, protected String $content, protected String $view )
    {
        /*
         * @inherit Yume\Fure\View\Tokenizer\Tokenizer
         *
         */
        $this->regexp =
            "/^(?:(?<syntax>" .
            "(?<indent>(\s){0,})" .
                "(?<prefix>\@)" .
                "(?<token>(match|switch))" .
                "(?<spaces>[\s|\t]+)" .
                "(?<params>[^\:]*)" .
                "(?<ending>\:\k{spaces}*\{)(?<enderr>[^\n]*)" .
                    "(?<inside>(\n\k{indent}[\s]+[^\n]*){0,})" .
                "(?<suffix>(\n\k{indent})*\})" .
            "))$/ms";
        
        $this->scheme  = "{ indent }<?php\n\n";
        $this->scheme .= "{ indent }{ output }{ token }( { params } )\n";
        $this->scheme .= "{ indent }{";
        $this->scheme .= "{ inside }\n";
        $this->scheme .= "{ indent }}{ closing }\n\n";
        $this->scheme .= "{ indent }?>";
    }
    
    /*
     * @inherit Yume\Fure\View\Tokenizer
     *
     */
    final protected function handler( AoE\Data $match ): ? String
    {
        // Default option.
        $match->output = "";
        $match->closing = "";
        
        // ...
        if( $this->isNonewOrWhiteSpace( $match->enderr ) )
        {
            // Clear double white spaces in parameter.
            $match->params = $this->clearer( $match->params );
            
            // If matching token is match.
            if( $match->token === "match" )
            {
                // Match is auto output.
                $match->output = "echo\x20";
                $match->closing = ";";
            } else {
                
                // Replace html tag.
                $match->inside = $this->htmlable( $match->inside );
            }
            
            // ...
            return( f( $this->scheme, $match ) );
        }
        //throw new SyntaxError();
    }
    
}

?>