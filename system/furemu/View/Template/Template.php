<?php

namespace Yume\Fure\View\Template;

use Yume\Fure\RegExp;

/*
 * Template
 *
 * @package Yume\Fure\View\Template
 */
class Template implements TemplateInterface
{
    
    public function __construct( String $loaded, Array $vars = [] )
    {
        # (?<!:)
        
        $regexp = f( "/(?:((?<Indent>^[\s|\t]*)({})))/imsJ", implode( "|", [
            implode( "", [
                "(?<Function>",
                    "\@(?<Expression>[^\:\n]*)\:\n",
                        "(?<Statement>\k{Indent}.*){0,}\k{Indent}$",
                ")"
            ])
        ]));
        
        echo "<pre>";
        echo htmlspecialchars( RegExp\RegExp::replace( $regexp, $loaded, function( $m )
        {
            // ...
            $match = RegExp\RegExp::clear( $m );
            
            // ...
            if( $match['Expression'] )
            {
                // ...
                $tokens = [
                    "for" => function( $expression, $statement )
                    {
                        // ...
                    },
                    "elif" => function( $expression, $statement )
                    {
                        // ...
                    },
                    "else" => function( $expression, $statement )
                    {
                        // ...
                    },
                    "exec" => function( $expression, $statement )
                    {
                        // ...
                    },
                    "if" => function( $expression, $statement )
                    {
                        // ...
                    },
                    "isset"=> function( $expression, $statement )
                    {
                        // ...
                    },
                    "match" => function( $expression, $statement )
                    {
                        // ...
                    },
                    "while" => function( $expression, $statement )
                    {
                        // ...
                    }
                ];
                
                if( $token = RegExp\RegExp::match( "/^(?:(?<Name>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*))/", $match['Expression'], True ) )
                {
                    if( isset( $tokens[$token['Name']] ) )
                    {
                        
                    }
                    return( f( "{}Token type unknown or invalid token \"{}\"", $match['Indent'], $token['Name'] ) );
                }
            }
            return( f( "{}Syntax error, Unexpected token \"{}\"", $match['Indent'], $match['Expression'] ) );
        }));
        exit;
    }
    
    public function render(): String
    {
        
    }
    
    public function phpTag( String $pair ): String
    {
        return( f( "<?php {} ?>", $pair ) );
    }
    
    public function __toString(): String
    {
        return( __METHOD__);
    }
    
}

?>