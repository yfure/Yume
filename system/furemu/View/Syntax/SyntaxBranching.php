<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;
use Yume\Fure\View;

use Closure;

/*
 * SyntaxBranching
 *
 * @extends Yume\Fure\View\Tokenizer\Tokenizer
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxBranching extends View\Tokenizer\Tokenizer
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
        $this->regexp = [
            [
                "pattern" => [
                    "/^(?:(?<syntax>",
                        "(?<indent>[\s]*)",
                        "(?<prefix>(\}[\s]*)*(\@))",
                        "(?<ntoken>(if|elif|else[\n\s]*if|else)\b)",
                        "(?<spaces>[\s]+)",
                        "(?<params>[^\:]*)",
                        "(?<ending>\:[\s\n]*\{)",
                    "))/m"
                ],
                "handler" => function( AoE\Data $match )
                {
                    // ...
                    $match->ntoken = str_replace( "\x20", "", $match->ntoken );
                    
                    // ...
                    switch( $match->ntoken )
                    {
                        case "if":
                            // var_dump( $match );
                            break;
                        case "elif":
                        case "elseif":
                            // var_dump( $match );
                            break;
                        case "else":
                            //bvar_dump( $match );
                            break;
                    }
                    return( $match->syntax );
                }
            ]
        ];
        
    }
    
    /*
     * @inherit Yume\Fure\View\Tokenizer
     *
     */
    final protected function handler( AoE\Data $match ): ? String
    {
        // ....
        return "";
    }
    
}

?>