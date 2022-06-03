<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

use Yume\Kama\Obi\HTTP;

abstract class PSTraceKeywords
{
    
    /*
     * Interfaces declared.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $interface = [];
    
    /*
     * Classes declared.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $classes = [];
    
    /*
     * Traits declared.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $traits = [];
    
    /*
     * Symbol pattern.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $symbol = [
        'name' => "symbol",
        'word' => [
            "\{|\}",
            "\[|\]",
            "\(|\)",
            "\:",
            "\\\\",
            "\*",
            "\%",
            "\+",
            "\."
        ]
    ];
    
    /*
     * Exception properties.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $key = [
        'name' => "key",
        'word' => [
            "code",
            "file",
            "line",
            "type",
            "args",
            "previous",
            "alias",
            "parent",
            "trace",
            "message"
        ]
    ];
    
    /*
     * PHP Data Types.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $data = [
        'name' => "data",
        'word' => [
            "String",
            "Integer",
            "Int",
            "Float",
            "Boolean",
            "Bool",
            "Array",
            "Object",
            "NULL",
            "Resource"
        ]
    ];
    
    /*
     * PHP Keywords.
     *
     * @access Public, Static
     *
     * @values Array
     */
    public static $keyword = [
        'name' => "keyword",
        'word' => [
            "abstract",
            "and",
            "as",
            "break",
            "callable",
            "case",
            "catch",
            "class",
            "clone",
            "const",
            "continue",
            "declare",
            "default",
            "do",
            "echo",
            "else",
            "elseif",
            "empty",
            "enddeclare",
            "endfor",
            "endforeach",
            "endif",
            "endswitch",
            "endwhile",
            "extends",
            "final",
            "finally",
            "fn",
            "for",
            "foreach",
            "function",
            "global",
            "goto",
            "if",
            "implements",
            "include",
            "include_once",
            "instanceof",
            "insteadof",
            "interface",
            "isset",
            "list",
            "namespace",
            "new",
            "or",
            "print",
            "private",
            "protected",
            "public",
            "require",
            "require_once",
            "return",
            "static",
            "switch",
            "throw",
            "trait",
            "try",
            "unset",
            "use",
            "var",
            "while",
            "xor",
            "yield",
            "yield\sfrom"
        ]
    ];
    
    /*
     * Register the class.
     *
     * @access Public, Static
     *
     * @return Void
     */
    public static function register(): Void
    {
        self::$interface = [
            'name' => "interface",
            'word' => get_declared_interfaces()
        ];
        self::$classes = [
            'name' => "class",
            'word' => get_declared_classes()
        ];
        self::$traits = [
            'name' => "trait",
            'word' => get_declared_traits()
        ];
    }
    
    /*
     * Search and Match by value.
     *
     * @access Public, Static
     *
     * @params
     *
     * @return String, False
     */
    public static function match( Mixed $subject, Array $searchs, PSTraceCliColor | PSTraceWebColor $color ): String | False
    {
        foreach( $searchs['word'] As $search )
        {
            if( strtolower( $search ) === strtolower( $subject ) )
            {
                return( $color->create( $subject, $searchs['name'] ) );
            }
        }
        return False;
    }
    
    /*
     * Search and Replace by pattern.
     *
     * @access Public, Static
     *
     * @params Mixed <subject>
     * @params Array <searchs>
     * @params Yume\Kama\Obi\Exception\PSTrace\PSTraceCliColor,
     *         Yume\Kama\Obi\Exception\PSTrace\PSTraceCliColor <color>
     *
     * @return String, False
     */
    public static function search( Mixed $subject, Array $searchs, PSTraceCliColor | PSTraceWebColor $color ): String | False
    {
        return( HTTP\Filter\RegExp::replace( "/(\>*)(.*?)(\<*\/*)/", $subject, function( $m ) use( $subject, $searchs, $color )
        {
            foreach( $searchs['word'] As $search )
            {
                $m[2] = HTTP\Filter\RegExp::replace( "/({$search})/i", $m[2], function( $m ) use( $searchs, $color )
                {
                    return( $color->create( $m[1], $searchs['name'] ) );
                });
            }
            return( $m[1] . $m[2] . $m[3] );
        }));
    }
    
}


?>