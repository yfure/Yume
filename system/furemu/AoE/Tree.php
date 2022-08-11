<?php

namespace Yume\Fure\AoE;

/*
 * Tree
 *
 * Create tree structure.
 *
 * @package Yume\Fure\AoE
 */
abstract class Tree
{
    
    public const LINER = 4732;
    public const POINT = 3579;
    public const SPACE = 2673;
    
    /*
     * Default space separartor.
     *
     * @access Public
     *
     * @values String
     */
    public const SPACES = "\x20\x20\x20\x20";
    
    /*
     * Tree row type.
     *
     * @access Protected
     *
     * @values Array
     */
    protected static $types = [
        self::LINER => [
            "│   ",
            "├── ",
            "└── "
        ],
        self::POINT => [
            "··· ",
            "··+ ",
            "··+ "
        ],
        self::SPACE => [
            self::SPACES,
            self::SPACES,
            self::SPACES
        ]
    ];
    
    /*
     * Create tree
     *
     * @access Public Static
     *
     * @params Array $array
     * @params Int $start
     * @params Int $type
     * @params String $space
     * @params Callable $key
     * @params Callable $val
     *
     * @return String
     */
    public static function tree( Array $array, Int $start = 0, Int $type = 0, String $space = "", ? Callable $key = Null, ? Callable $val = Null ): String
    {
        
        // The default value for event key.
        $key = $key !== Null ? $key : fn( $key ) => $key;
        
        // The default value for event value.
        $val = $val !== Null ? $val : fn( $key, $val, $type ) => $val;
        
        // If first space is not empty.
        if( $start !== 0 && $space === "" )
        {
            for( $i = 0; $i < $start; $i++ )
            {
                $space .= "\x20";
            }
        }
        
        // Set default type if type is 0.
        $type = $type !== 0 ? $type : self::LINER;
        
        return( self::loop( $array, $type, $space, $key, $val ) );
        
    }
    
    /*
     * Looping array.
     *
     * @access Private Static
     *
     * @params Array $array
     * @params Int $type
     * @params String $space
     * @params Callable $key
     * @params Callable $val
     *
     * @return String
     */
    private static function loop( Array $array, Int $type, String $space, Callable $key, Callable $val ): String
    {
        // Iteration start.
        $iter = 0;
        
        // Result stacks.
        $result = "";
        
        // Check if array is not empty.
        if( count( $array ) !== 0 )
        {
            foreach( $array As $k => $v )
            {
                
                $iter++;
                
                // If current iterate is last.
                if( count( $array ) === $iter )
                {
                    $lineKey = self::$types[$type][2];
                    $lineVal = self::SPACES;
                } else {
                    $lineKey = self::$types[$type][1];
                    $lineVal = self::$types[$type][0];
                }
                
                // Create format.
                $result = f( "{}{}{}", $result, $space, $lineKey );
                
                // If array key is Int not String.
                if( is_int( $k ) )
                {
                    // If value is array.
                    if( is_array( $v ) )
                    {
                        // Looping.
                        $result = f( "{}{}\n{}", $result, call_user_func_array( $key, [ "Array" ] ), self::loop( $v, $type, $space . $lineVal, $key, $val ) );
                    } else {
                        
                        // Parse value.
                        $result = f( "{}{}", $result, self::value( $v, $k, $type, $space, $lineVal, $key, $val ) );
                    }
                } else {
                    
                    // Create format.
                    $result = f( "{}{}\n", $result, call_user_func_array( $key, [ $k ] ) );
                    
                    // If value is array.
                    if( is_array( $v ) )
                    {
                        // Looping.
                        $result = f( "{}{}", $result, self::loop( $v, $type, $space . $lineVal, $key, $val ) );
                    } else {
                        
                        // Parse value.
                        $result = f( "{}{}{}{}{}", $result, $space, $lineVal, self::$types[$type][2], self::value( $v, $k, $type, $space, $lineVal, $key, $val ) );
                    }
                }
                
            }
        } else {
            
            // Last.
            $result = f( "{}{}{}{}\n", $result, $space, self::$types[$type][2], call_user_func_array( $val, [ 'Array', "Empty", "Array" ] ) );
        }
        
        return $result;
    }
    
    /*
     * Handle array value.
     *
     * @access Private Static
     *
     * @params Mixed $v
     * @params Mixed $k
     * @params Int $type
     * @params String $space
     * @params String $lineVal
     * @params Callable $key
     * @params Callable $val
     *
     * @return String
     */
    private static function value( Mixed $v, Mixed $k, Int $type, String $space, String $lineVal, Callable $key, Callable $val ): String
    {
        if( is_bool( $v ) )
        {
            $re = call_user_func_array( $val, [ $k, $v, "Bool" ] );
        }
        else if( is_array( $v ) )
        {
            $re = self::loop( $v, $type, $space . $lineVal, $key, $val );
        }
        else if( is_callable( $v ) )
        {
            $re = call_user_func_array( $val, [ $k, "Closure", "Callable" ] );
        }
        else if( is_object( $v ) )
        {
            $re = call_user_func_array( $val, [ $k, $v::class, "Object" ] );
        }
        else {
            $re = call_user_func_array( $val, [ $k, $v, "Unknown" ] );
        }
        return( f( "{}\n", $re === Null ? "Empty" : $re ) );
    }
    
}

?>