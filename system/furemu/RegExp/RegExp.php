<?php

namespace Yume\Fure\RegExp;

/*
 * RegExp
 *
 * @package Yume\Fure\RegExp
 */
abstract class RegExp
{
    
    /*
     * @inherit https://www.php.net/manual/en/function.preg-last-error.php
     *
     */
    public static function errno(): Int
    {
        return( preg_last_error() );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/function.preg-last-error-msg.php
     *
     */
    public static function error(): String
    {
        return( preg_last_error_msg() );
    }
    
    public static function etype( Int $errno = 7668 ): String
    {
        return( match( self::errno() )
        {
            2 => "PREG_BACKTRACK_LIMIT_ERROR",
            4 => "PREG_BAD_UTF8_ERROR",
            5 => "PREG_BAD_UTF8_OFFSET_ERROR",
            1 => "PREG_INTERNAL_ERROR",
            6 => "PREG_JIT_STACKLIMIT_ERROR",
            0 => "PREG_NO_ERROR",
            3 => "PREG_RECURSION_LIMIT_ERROR"
        });
        
    }
    
    /*
     * Perform a regular expression match.
     *
     * @access Public Static
     *
     * @params String $pattern
     * @params String $subject
     *
     * @return Bool
     */
    public static function test( String $pattern, String $subject ): Int | Bool
    {
        // Parse preg-match return into boolean type.
        $match = ( ( Bool ) preg_match( $pattern, $subject ) );
        
        // Check if an error occurred.
        if( self::errno() )
        {
            throw new RegExpError( self::error(), self::errno() );
        }
        
        return( $match );
    }
    
    public static function clear( Array $matchs, Bool $capture = False ): Array
    {
        foreach( $matchs As $i => $match )
        {
            if( is_int( $i ) )
            {
                if( $i === 0 && $capture === False )
                {
                    continue;
                }
                unset( $matchs[$i] );
            } else {
                if( is_array( $match ) )
                {
                    foreach( $match As $u => $result )
                    {
                        $matchs[$i][$u] = $result !== "" ? $result : Null;
                    }
                } else {
                    $matchs[$i] = $match !== "" ? $match : Null;
                }
            }
        }
        return( $matchs );
    }
    
    /*
     * Retrieves the result of matching a string against a regular expression.
     *
     * @access Public Static
     *
     * @params String $pattern
     * @params String $subject
     * @params Bool $clear
     *
     * @return Array|Bool
     */
    public static function match( String $pattern, String $subject, Bool $clear = False ): Array | Bool
    {
        $matchs = [];
        
        // ....
        if( preg_match( $pattern, $subject, $matchs, PREG_UNMATCHED_AS_NULL ) )
        {
            return( $clear ? self::clear( $matchs ) : $matchs );
        }
        
        // Check if an error occurred.
        if( self::errno() )
        {
            throw new RegExpError( self::error(), self::errno() );
        }
        
        return( False );
    }
    
    /*
     * Executes a search for a match in a specified string.
     *
     * @access Public Static
     *
     * @params String $pattern
     * @params String $subject
     * @params Bool $clear
     *
     * @return Array|Bool
     */
    public static function matchs( String $pattern, String $subject, Bool $clear = False ): Array | Bool
    {
        $matchs = [];
        
        // ...
        if( preg_match_all( $pattern, $subject, $matchs, PREG_SET_ORDER || PREG_UNMATCHED_AS_NULL ) )
        {
            return( $clear ? self::clear( $matchs ) : $matchs );
        }
        
        // Check if an error occurred.
        if( self::errno() )
        {
            throw new RegExpError( self::error(), self::errno() );
        }
        
        return( False );
    }
    
    /*
     * Replace string with regexp.
     *
     * @access Public Static
     *
     * @params  $
     *
     * @return Array|String
     */
    public static function replace( Array | String $pattern, Array | String $subject, Array | Callable | String $replace/*, Bool $clear = False */ ): Array | String
    {
        $result = Null;
        
        $patType = ucfirst( gettype( $pattern ) );
        $subType = ucfirst( gettype( $subject ) );
        $repType = ucfirst( gettype( $replace ) );
        
        if( $subType === "Array" )
        {
            if( $patType === "Array" )
            {
                if( $repType === "Array" )
                {
                    for( $i = 0; $i < $count; $i++ )
                    {
                        $subject[$i] = is_string( $replace[$i] ) ? 
                            preg_replace( $pattern[$i], $replace[$i], $subject[$i] ) : 
                            preg_replace_callback( $pattern[$i], $replace[$i], $subject[$i] ) ;
                    }
                    $result = $subject;
                }
                else {
                    for( $i = 0; $i < $count; $i++ )
                    {
                        $subject[$i] = is_string( $replace ) ? 
                            preg_replace( $pattern[$i], $replace, $subject[$i] ) : 
                            preg_replace_callback( $pattern[$i], $replace, $subject[$i] ) ;
                    }
                    $result = $subject;
                }
            }
            if( $patType === "String" )
            {
                if( $repType === "Array" )
                {
                    for( $i = 0; $i < $count; $i++ )
                    {
                        $subject[$i] = is_string( $replace[$i] ) ?
                            preg_replace( $pattern, $replace[$i], $subject[$i] ) : 
                            preg_replace_callback( $pattern, $replace[$i], $subject[$i] ) ;
                    }
                    $result = $subject;
                }
                else {
                    for( $i = 0; $i < count( $subject ); $i++ )
                    {
                        $subject[$i] = is_string( $replace ) ?
                            preg_replace( $pattern, $replace, $subject[$i] ) : 
                            preg_replace_callback( $pattern, $replace, $subject[$i] ) ;
                    }
                    $result = $subject;
                }
            }
        } else if( $subType === "String" )
        {
            if( $patType === "String" && ( $repType === "String" || $repType === "Object" ) )
            {
                if( $repType === "String" )
                {
                    $result = preg_replace( $pattern, $replace, $subject );
                } else {
                    $result = preg_replace_callback( $pattern, $replace, $subject );
                }
            }
            if( $patType === "Array" && $repType === "Array" )
            {
                for( $i = 0; $i < $count; $i++ )
                {
                    $subject = is_string( $replace[$i] ) ? 
                        preg_replace( $pattern[$i], $replace[$i], $subject ) : 
                        preg_replace_callback( $pattern[$i], $replace[$i], $subject );
                }
                $result = $subject;
            }
            if( $patType === "Array" )
            {
                for( $i = 0; $i < count( $pattern ); $i++ )
                {
                    $subject = is_string( $replace ) ? 
                        preg_replace( $pattern[$i], $replace, $subject ) : 
                        preg_replace_callback( $pattern[$i], $replace, $subject );
                }
                $result = $subject;
            }
        }
        
        // Check if an error occurred.
        if( self::errno() )
        {
            throw new RegExpError( self::error(), self::errno() );
        }
        
        // Return replace results.
        return( $result );
    }
    
}

?>