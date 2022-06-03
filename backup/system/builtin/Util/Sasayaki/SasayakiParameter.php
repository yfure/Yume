<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;

abstract class SasayakiParameter
{
    /*
     * Create function parameter.
     *
     * @access Public, Static
     *
     * @params String <params>
     * @params Array <v>
     * @params Array, Yume\Kama\Obi\AoE\Hairetsu <data>
     *
     * @return Array
     */
    public static function params( String $params, Array & $v, Array | AoE\Hairetsu $data ): Array
    {
        
        /*
         * Exploding comma-comma separator.
         *
         * @values Array.
         */
        $expl = explode( ",", HTTP\Filter\RegExp::replace( "/\r|\t|\n/", $params, "" ) );
        
        foreach( $expl As $i => $single )
        {
            $match = [];
            
            if( HTTP\Filter\RegExp::match( "/\"([^\"]*)\"|\'([^\']*)\'/", $single, $match ) )
            {
                $v['params'][$i] = $match[1];
            } else {
                $v['params'][$i] = match( strtoupper( $single ) )
                {
                    // Parse to Array.
                    "[]" => [],
                    
                    // Parse to Null.
                    "NULL" => Null,
                    
                    // Parse to True.
                    "TRUE" => True,
                    
                    // Parse to False.
                    "FALSE" => False,
                    
                    // Embed parameter.
                    default => self::embed( $single, $data )
                };
            }
        }
        
        return( $v['params'] );
    }
    
    /*
     * Specifying object constants and properties.
     *
     * @access Public, Static
     *
     * @params String <content>
     * @params Array, Yume\Kama\Obi\AoE\Hairetsu <data>
     *
     * @return Mixed
     */
    public static function embed( String $content, Array | AoE\Hairetsu $data ): Mixed
    {
        
        if( HTTP\Filter\RegExp::match( "/^\d+$/", $content ) )
        {
            // Parse to Int.
            return( ( Int ) $content );
        } else {
            
            $const = [];
            
            // If the parameter is a constant.
            if( ( $x = new SasayakiConstant( $content, [], $const ) )->getContent() !== $content )
            {
                return( $const[0]['values'] );
            } else {
                
                $const = [];
                
                // If the parameter is a constant of type object.
                if( ( new SasayakiObjectConstant( $content, [], $const ) )->getContent() !== $content )
                {
                    return( $const[0]['values'] );
                }
            }
            
            $vars = [];
            
            // If the parameter is a variable.
            if( ( new SasayakiVariable( $content, $data, $vars ) )->getContent() !== $content )
            {
                return( $vars[0]['values'] );
            } else {
                
                $vars = [];
                
                // If the parameter is a variable type object.
                if( ( new SasayakiObjectVariable( $content, [], $vars ) )->getContent() !== $content )
                {
                    return( $vars[0]['values'] );
                }
            }
            
            // If the parameter is a class object.
            if( ( $r = new SasayakiObject( $content, $data ) )->getContent() !== $content )
            {
                return( $r )->getContent();
            }
            
            // Mismatch parameter type.
            return( $content );
            
        }
    }
    
}

?>