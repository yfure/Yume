<?php

namespace Yume\Kama\Obi\RegExp;

abstract class RegExp
{
    
    /*
     * ...
     *
     * @access Public: Static
     *
     * @params  $
     *
     * @return Array|String
     */
    public static function replace( Array | String $subject, Array | String $pattern, Array | Callable | String $replace ): Array | String
    {
        $subIs = ucfirst( gettype( $subject ) );
        $patIs = ucfirst( gettype( $pattern ) );
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
            if( $patIs === "String" && $repIs === "String" )
            {
                return( preg_replace( $pattern, $replace, $subject ) );
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