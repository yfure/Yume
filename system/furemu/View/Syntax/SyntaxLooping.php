<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;
use Yume\Fure\View;

use Closure;

/*
 * SyntaxLooping
 *
 * Handle looping syntax e.g for, foreach, while, do-while
 *
 * @extends Yume\Fure\View\Tokenizer\Tokenizer
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxLooping extends View\Tokenizer\Tokenizer
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
            "do" => [
                "pattern" => [
                    "/^(?:(?<syntax>",
                        "(?<indent>(\s){0,})",
                        "(?<prefixForDo>\@)",
                        "(?<ntokenForDo>(do\b))",
                        "(?<spaces>[\s]+)",
                        "(?<beforeForDo>[^\:]*)",
                        "(?<endingForDo>\:\k{spaces}*\{)(?<enderrForDo>[^\n]*)",
                            "(?<inside>(\n\k{indent}[\s]+[^\n]*){0,})",
                        "(?<suffixForDo>(\n\k{indent})*\})",
                        "(?<prefixForWh>([^\@]*))",
                        "(\@)",
                        "(?<ntokenForWh>(while\b))",
                        "(?<spacesForWh>[\s]+)",
                        "(?<params>([^\:]*))",
                        "(?<suffixForWh>\:",
                            "(?<sufferForWh>([^\n]*))",
                        ")",
                    "))/msJ"
                ],
                "rscheme" => implode( "", [
                    "{ indent }<?php\n\n",
                    "{ indent }do\n",
                    "{ indent }{",
                    "{ inside }\n",
                    "{ indent }}\n",
                    "{ indent }while( { params } );\n\n",
                    "{ indent }?>"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    // Replace html tag.
                    $match->inside = $this->htmlable( $match->inside );
                    
                    // Clear double white spaces in parameter.
                    $match->params = $this->clearer( $match->params );
                    
                    // ...
                    return( f( $this->regexp['do']['rscheme'], $match ) );
                }
            ],
            "any" => [
                "pattern" => [
                    "/^(?:(?<syntax>",
                        "(?<indent>(\s){0,})",
                        "(?<prefix>\@)",
                        "(?<token>(for|foreach|while))",
                        "(?<spaces>[\s]+)",
                        "(?<params>[^\:]*)",
                        "(?<ending>\:\k{spaces}*\{)(?<enderr>[^\n]*)",
                            "(?<inside>(\n\k{indent}[\s]+[^\n]*){0,})",
                        "(?<suffix>(\n\k{indent})*\})",
                    "))$/ms"
                ],
                "rscheme" => implode( "", [
                    "{ indent }<?php\n\n",
                    "{ indent }{ token }( { params } )\n",
                    "{ indent }{",
                    "{ inside }\n",
                    "{ indent }}\n\n",
                    "{ indent }?>"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    // Replace html tag.
                    $match->inside = $this->htmlable( $match->inside );
                    
                    // Clear double white spaces in parameter.
                    $match->params = $this->clearer( $match->params );
                    
                    // ...
                    return( f( $this->regexp['any']['rscheme'], $match ) );
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
        return "";
    }
    
}

?>