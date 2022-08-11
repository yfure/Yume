<?php

namespace Yume\Fure\View;

use Yume\Fure\Reflector;
use Yume\Fure\Services;
use Yume\Fure\Error;

/*
 * ViewServices
 *
 * @extends Yume\Fure\Services\Services
 *
 * @package Yume\Fure\View
 */
final class ViewServices extends Services\Services
{
    
    /*
     * @inherit Yume\Fure\Services\Services
     *
     */
    public static function boot(): Void
    {
        // Mapping parser classes.
        array_map( array: View::config( "parsers" ), callback: function( String $token )
        {
            // If tokenization class does not implement Interface Tokenizer.
            if( Reflector\ReflectClass::isImplements( $token, Tokenizer\TokenizerInterface::class ) === False )
            {
                throw new Error\ImplementError([ $token, Tokenizer\TokenizerInterface::class ]);
            }
        });
        /*
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
                        "\@(?<token>(for|foreach|match|while)\b)([\s|\t]*)(?<params>[^\:]*)(?<opening>\:)(?<invalid>[^\n]*)",
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
            ],
            [
                "indent" => False,
                "regexp" => implode( "", [
                    "/(?:(?<syntax>",
                        "\@(?<token>(echo|print|return)\b|(\:|\/))",
                        "(?<space>[\s|\t]*)",
                        "(?<value>[^\;]*)(?<closing>\;)",
                    "))/mi"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    if( $match->value !== strtoupper( $match->value ) && RegExp\RegExp::test( "/^[a-zA-Z0-9]+$/", $match->value ) )
                    {
                        $match->value = f( "\${}", $match->value );
                    }
                    
                    // ...
                    if( $match->token === "/" )
                    {
                        $match->value = f( "htmlspecialchars( {} )", $match->value );
                    }
                    
                    // Check if token is shorthand.
                    $match->token = match( $match->token )
                    {
                        
                        ":",
                        "/" => "echo",
                        
                        default => $match->token
                    };
                    
                    return( f( "<?php {} {}; ?>", [
                        $match->token,
                        $match->value
                    ]));
                }
            ],
            [
                "indent" => False,
                "regexp" => implode( "", [
                    "/(?:(?<syntax>\@",
                        "(?<named>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)",
                        "(?<space>[\s|\t]*)\=\k{space}*",
                        "(?<value>[^\;]*)\;",
                    "))/mi"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    // If variable names are capitalized they will be treated as constants.
                    if( $match->named === strtoupper( $match->named ) )
                    {
                        // Define or create a new constant.
                        $match->code = f( "<?php defined( \"{named}\" ) ? \"\" : define( \"{named}\", {value} ); ?>", [
                            "named" => $match->named,
                            "value" => $match->value
                        ]);
                    } else {
                        
                        // Variable assigment.
                        $match->code = f( "<?php \${} = {}; ?>", [
                            $match->named,
                            $match->value
                        ]);
                    }
                    return( $match->code );
                }
            ],
            [
                "indent" => False,
                "regexp" => implode( "", [
                    "/(?:(?<syntax>",
                        "\@(?<named>([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*))",
                        "(?<space>[\s|\t]*)",
                        "(?<end>[^\;]*)\;",
                    "))/mi"
                ]),
                "handler" => function( AoE\Data $match )
                {
                    // Check if the name is a constant or function.
                    if( $match->named === strtoupper( $match->named ) || RegExp\RegExp::test( "/^\(([^\)]*)\)$/m", $match->end ) )
                    {
                        return( f( "<?php {}{}; ?>", $match->named, $match->end ) );
                    }
                    return( f( "<?php \${}{}; ?>", $match->named, $match->end ) );
                }
            ],
            [
                "indent" => False,
                "regexp" => "/(?<indent>[\s|\t]*)\#[\s|\t]*(?<text>[^\n]*)/",
                "handler" => fn( AoE\Data $match ) => f( "", $match->text )
            ]
        ];
        
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
    }
    
}

?>