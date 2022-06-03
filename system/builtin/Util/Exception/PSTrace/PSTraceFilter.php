<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

abstract class PSTraceFilter
{
    public static function keyword( String $type, Mixed $val, PSTraceCliColor | PSTraceWebColor $col )
    {
        $type = strtolower( $type );
        
        $val = $val === Null? "Null" : $val;
        $val = $val === True? "True" : $val;
        $val = $val === False? "False" : $val;
        
        $val = str_replace( BASE_PATH, "", $val );
        
        if( $type === "key" ) {
            if( $interface = PSTraceKeywords::match( $val, PSTraceKeywords::$interface, $col ) ) {
                return( PSTraceKeywords::search( $interface, PSTraceKeywords::$symbol, $col ) );
            }
            if( $class = PSTraceKeywords::match( $val, PSTraceKeywords::$classes, $col ) ) {
                return( PSTraceKeywords::search( $class, PSTraceKeywords::$symbol, $col ) );
            }
            if( $trait = PSTraceKeywords::match( $val, PSTraceKeywords::$traits, $col ) ) {
                return( PSTraceKeywords::search( $trait, PSTraceKeywords::$symbol, $col ) );
            }
            if( $key = PSTraceKeywords::match( $val, PSTraceKeywords::$key, $col ) ) {
                return( $key );
            }
            if( $data = PSTraceKeywords::match( $val, PSTraceKeywords::$data, $col ) ) {
                return( $data );
            }
            if( $keyword = PSTraceKeywords::match( $val, PSTraceKeywords::$keyword, $col ) ) {
                return( $keyword );
            }
        }
        if( $type === "val.message" ) {
            return( $col->create( "\"{$val}\"", "string" ) );
        }
        if( $type === "val.function" ) {
            return( $col->create( $val, "function" ) );
        }
        if( $type === "val.line" || $type === "val.code" || is_int( $val ) || is_integer( $val ) ) {
            return( $col->create( $val, "code" ) );
        }
        if( $data = PSTraceKeywords::match( $val, PSTraceKeywords::$data, $col ) ) {
            return( $data );
        }
        if( $type === "val.type" ) {
            return( $col->create( $val, "type" ) );
        }
        if( $class = PSTraceKeywords::match( $val, PSTraceKeywords::$classes, $col ) ) {
            return( PSTraceKeywords::search( $class, PSTraceKeywords::$symbol, $col ) );
        }
        if( substr( $val, -4 ) === ".php" || substr( $val, -5 ) === ".yume" || substr( $val, 1 ) === "/" ) {
            return( $col->create( PSTraceKeywords::search( $val, PSTraceKeywords::$symbol, $col ), "file" ) );
        }
        if( $val === "Empty" ) {
            return( $col->create( $val, "empty" ) );
        }
        return( PSTraceKeywords::search( $col->create( str_replace( [ "\r", "\t", "\n" ], [ "\\r", "\\t", "\\n" ], htmlspecialchars( $val ) ), "mis" ), PSTraceKeywords::$symbol, $col ) );
    }
}

?>