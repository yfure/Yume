<?php

namespace Yume\Kama\Obi\RegExp;

abstract class RegExp
{
    
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
        return( ( Bool ) $match = preg_match( $pattern, $subject ) );
    }
    
    /*
     * Retrieves the result of matching a string against a regular expression.
     *
     * @access Public Static
     *
     * @params String $pattern
     * @params String $subject
     *
     * @return Array|Bool
     */
    public static function match( String $pattern, String $subject ): Array | Bool
    {
        $matchs = [];
        
        if( preg_match( $pattern, $subject, $matchs, PREG_UNMATCHED_AS_NULL ) )
        {
            return( $matchs );
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
     *
     * @return Array|Bool
     */
    public static function matchs( String $pattern, String $subject ): Array | Bool
    {
        $matchs = [];
        
        if( preg_match_all( $pattern, $subject, $matchs, PREG_SET_ORDER || PREG_UNMATCHED_AS_NULL ) )
        {
            return( $matchs );
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
    public static function replace( Array | String $pattern, Array | String $subject, Array | Callable | String $replace ): Array | String
    {
        $patIs = ucfirst( gettype( $pattern ) );
        $subIs = ucfirst( gettype( $subject ) );
        $repIs = ucfirst( gettype( $replace ) );
        
        if( $subIs === "Array" )
        {
            if( $patIs === "Array" )
            {
                if( count( $subject ) !== ( $count = count( $pattern ) ) )
                {
                    throw new Exception;
                }
                if( $repIs === "Array" )
                {
                    if( count( $subject ) !== ( $count = count( $replace ) ) )
                    {
                        throw new Exception;
                    }
                    for( $i = 0; $i < $count; $i++ )
                    {
                        $subject[$i] = is_string( $replace[$i] ) ? 
                            preg_replace( $pattern[$i], $replace[$i], $subject[$i] ) : 
                            preg_replace_callback( $pattern[$i], $replace[$i], $subject[$i] ) ;
                    }
                    return( $subject );
                }
                for( $i = 0; $i < $count; $i++ )
                {
                    $subject[$i] = [];
                }
                return( $subject );
            }
            if( $patIs === "String" )
            {
                if( $repIs === "Array" )
                {
                    if( count( $subject ) !== ( $count = count( $replace ) ) )
                    {
                        throw new Exception;
                    }
                    for( $i = 0; $i < $count; $i++ )
                    {
                        $subject[$i] = is_string( $replace[$i] ) ?
                            preg_replace( $pattern, $replace[$i], $subject[$i] ) : 
                            preg_replace_callback( $pattern, $replace[$i], $subject[$i] ) ;
                    }
                    return( $subject );
                }
                for( $i = 0; $i < count( $subject ); $i++ )
                {
                    $subject[$i] = is_string( $replace ) ?
                        preg_replace( $pattern, $replace, $subject[$i] ) : 
                        preg_replace_callback( $pattern, $replace, $subject[$i] ) ;
                }
                return( $subject );
            }
        }
        if( $subIs === "String" )
        {
            if( $patIs === "String" && ( $repIs === "String" || $repIs === "Object" ) )
            {
                if( $repIs === "String" )
                {
                    return( preg_replace( $pattern, $replace, $subject ) );
                }
                return( preg_replace_callback( $pattern, $replace, $subject ) );
            }
            if( $patIs === "Array" && $repIs === "Array" )
            {
                if( count( $pattern ) !== ( $count = count( $replace ) ) )
                {
                    throw new Exception;
                }
                for( $i = 0; $i < $count; $i++ )
                {
                    $subject = is_string( $replace[$i] ) ? 
                        preg_replace( $pattern[$i], $replace[$i], $subject ) : 
                        preg_replace_callback( $pattern[$i], $replace[$i], $subject );
                }
                return( $subject );
            }
            if( $patIs === "Array" )
            {
                for( $i = 0; $i < count( $pattern ); $i++ )
                {
                    $subject = is_string( $replace ) ? 
                        preg_replace( $pattern[$i], $replace, $subject ) : 
                        preg_replace_callback( $pattern[$i], $replace, $subject );
                }
                return( $subject );
            }
        }
    }
    
}

?>