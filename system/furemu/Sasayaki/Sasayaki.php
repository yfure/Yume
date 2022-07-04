<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\Trouble;

class Sasayaki
{
    
    public String $view;
    
    public function __construct()
    {
        HTTP\HTTP::header( "Content-Type: application/json" );
        
        $pattern = f( "/(?:(?<Indent>[\s|\t]*)(({})|({})))/m",
            implode( "", [
                "(?<For>\bfor\b[\s|\t]*",
                    "\[{2}",
                        "(?<ForConditional>[^\]{2}]*)",
                    "\]{2}\;\s*\bdo\b",
                ")",
                "(?<ForState>",
                    "(",
                        "\n\\1[\s|\t]+",
                        ".*[^\n]*",
                    "){0,}",
                ")",
                "(?<Done>\n\\1done\;)"
            ]),
            implode( "", [
                "(?<If>\bif\s*\[{2}([^\]{2}]+)\]{2}\;\s*then)",
                "(?<IfState>",
                    "(",
                        "\n\\1[\s|\t]+",
                        ".*[^\n]*",
                    "){0,}",
                ")",
                "(",
                    "\n\\1",
                    "(?<Elif>\belif\s*\[{2}([^\]{2}]+)\]{2}\;\s*then)",
                    "(?<ElifState>",
                        "(",
                            "\n\\1[\s|\t]+",
                            ".*[^\n]*",
                        "){0,}",
                    ")",
                "){0,}",
                "(",
                    "\n\\1",
                    "(?<Else>\belse\;\s*then)",
                    "(?<ElseState>",
                        "(",
                            "\n\\1[\s|\t]+",
                            ".*[^\n]*",
                        "){0,}",
                    ")",
                "){0,1}",
                "(?<Fi>\n\\1fi\;)"
            ]),
            "(?<RegExp>\/(?<RegExpPattern>.*)\/)",
            "(?<Constant>(.[^\n]*)",
            "(?<Function>(.[^\n]*)",
            "(?<FunctionProtptype>(.[^\n]*)",
            "(?<Variable>(.[^\n]*)",
            "(?<Argument>(.[^\n]*)",
            "(?<Operator>(.[^\n]*)",
            "(?<Assigment>(.[^\n]*)",
            "(?<Throwable>(.[^\n]*)",
            "(?<RegExp>(.[^\n]*)",
            "(?<Match>(.[^\n]*)",
            "(?<Array>(.[^\n]*)",
            "(?<ArrayPrototype>(.[^\n]*)",
            "(?<String>(.[^\n]*)",
            "(?<StringPrototype>(.[^\n]*)",
            "(?<Object>(.[^\n]*)",
            "(?<ObjectName>(.[^\n]*)",
            "(?<ObjectSpace>(.[^\n]*)",
            "(?<ObjectMethod>(.[^\n]*)",
            "(?<ObjectConstant>(.[^\n]*)",
            "(?<ObjectProperty>(.[^\n]*)",
            "(?<ObjectPrototype>(.[^\n]*)"
        );
        
        $strings = implode( "\n", [
            "",
            "while [[ ]]; do",
            "    ",
            "done;",
            "",
            "for [[ \$i, \$v in \$x ]]; do",
            "    if [[ \$i === \$i.length ]]; then",
            "        puts \"Last\"",
            "    fi;",
            "done;",
            "",
            "if [[ isset \$x ]]; then",
            "    puts \"X is exists\"",
            "elif [[ isset \$y ]]; then",
            "    puts \"Y is exists\"",
            "else; then",
            "    puts \"None\"",
            "fi;",
            ""
        ]);
        
        if( $matched = RegExp\RegExp::matchs( $pattern, $strings ) )
        {
            foreach( $matched As $i => $v )
            {
                if( is_int( $i ) )
                {
                    if( $i !== 0 )
                    {
                        unset( $matched[$i] );
                    }
                } else {
                    foreach( $v As $u => $e )
                    {
                        if( $e === Null || $e === "" )
                        {
                            $matched[$i][$u] = Null;
                        }
                    }
                }
            }
        }
        
        echo Stringable::parse( $matched );
    }
    
}

?>