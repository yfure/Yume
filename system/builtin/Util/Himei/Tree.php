<?php

namespace Yume\Util\Himei;

/*
 * Tree utility class.
 *
 * @package Yume\Util\Himei
 */
abstract class Tree
{
    
    public const LINER = 4732;
    public const POINT = 3579;
    public const SPACE = 2673;
    
    public const SPACES = "    ";
    
    protected static $types = [
        self::LINER => [
            "│   ",
            "├── ",
            "└── "
        ],
        self::POINT => [
            "..+ ",
            "..+ ",
            "..+ "
        ],
        self::SPACE => [
            self::SPACES,
            self::SPACES,
            self::SPACES
        ]
    ];
    
    public static function tree( Array $array, Int $start = 0, Int $type = 0, String $space = "", ? Callable $key = Null, ? Callable $val = Null ): String
    {
        
        // // The default value for event key.
        $key = $key !== Null ? $key : fn( $key ) => $key;
        
        // The default value for event value.
        $val = $val !== Null ? $val : fn( $key, $val, $type ) => $val;
        
        if( $start !== 0 && $space === "" )
        {
            for( $i = 0; $i < $start; $i++ )
            {
                $space .= " ";
            }
        }
        
        // Set default type if type is 0.
        $type = $type !== 0 ? $type : self::LINER;
        
        return( self::loop( $array, $type, $space, $key, $val ) );
        
    }
    
    private static function loop( Array $array, Int $type, String $space, Callable $key, Callable $val )
    {
        $iter = 0;
        $result = "";
        
        if( count( $array ) !== 0 )
        {
            foreach( $array As $k => $v )
            {
                
                $iter++;
                
                if( count( $array ) === $iter )
                {
                    $lineKey = self::$types[$type][2];
                    $lineVal = self::SPACES;
                } else {
                    $lineKey = self::$types[$type][1];
                    $lineVal = self::$types[$type][0];
                }
                
                $result .= $space;
                $result .= $lineKey;
                
                if( is_int( $k ) )
                {
                    if( is_array( $v ) )
                    {
                        $result .= call_user_func_array( $key, [ "Array" ] ) . "\n";
                        $result .= self::loop( $v, $type, $space . $lineVal, $key, $val );
                    } else {
                        $result .= self::value( $v, $k, $type, $space, $lineVal, $key, $val );
                    }
                } else {
                    
                    $result .= call_user_func_array( $key, [ $k ] ) . "\n";
                    
                    if( is_array( $v ) )
                    {
                        $result .= self::loop( $v, $type, $space . $lineVal, $key, $val );
                    } else {
                        $result .= $space;
                        $result .= $lineVal;
                        $result .= self::$types[$type][2];
                        $result .= self::value( $v, $k, $type, $space, $lineVal, $key, $val );
                    }
                }
                
            }
        } else {
            $result .= $space;
            $result .= self::$types[$type][2];
            $result .= call_user_func_array( $val, [ 'Array', "Empty", "Array" ] ) . "\n";
        }
        
        return $result;
    }
    
    private static function value( Mixed $v, Mixed $k, Int $type, String $space, String $lineVal, Callable $key, Callable $val )
    {
        if( is_bool( $v ) ) {
            $re = call_user_func_array( $val, [ $k, $v, "Bool" ] );
        } else
        if( is_array( $v ) ) {
            $re = self::loop( $v, $type, $space . $lineVal, $key, $val );
        } else
        if( is_callable( $v ) ) {
            $re = call_user_func_array( $val, [ $k, "Closure", "Callable" ] );
        } else
        if( is_object( $v ) ) {
            $re = call_user_func_array( $val, [ $k, $v::class, "Object" ] );
        } else {
            $re = call_user_func_array( $val, [ $k, $v, "Unknown" ] );
        }
        return( "{$re}\n" );
    }
    
}

?>
