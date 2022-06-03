<?php

namespace Yume\Func;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Trouble;

/*
 * Get configuration file.
 *
 * @params String <config>
 *
 * @return Mixed
 */
function config( String $config ): Mixed
{
    // Explode config name.
    $expl = explode( ".", $config );
    
    // Create file name.
    $file = strtolower( $expl[0] );
    
    // Add extension if not present.
    $file .= ".php";
    
    // If the configuration file exists.
    if( file_exists( $file = path( config: "/{$file}" ) ) )
    {
        
        // Return value from config file.
        $conf = require( $file );
        
        // Unset first element.
        array_shift( $expl );
        
        if( count( $expl ) !== 0 )
        {
            return( ify( $expl, $conf ) );
        }
        return $conf;
    }
    throw new Trouble\Exception\ModuleError( "No config named {$file}" );
}

/*
 * Retrieve element values using dot as array separator.
 *
 * @params Array, String <str>
 * @params Array <arr>
 *
 * @return Mixed
 */
function ify( Array | String $str, Array | AoE\Hairetsu $arr ): Mixed
{
    
    /*
     * Split string with period.
     *
     * @values Array
     */
    $expl = is_array( $str ) ? $str : explode( ".", $str );
    
    /*
     * Data Result
     *
     * @values Mixed
     */
    $data = [];
    $eval = "\$arr";
    
    foreach( $expl As $i => $key )
    {
        //$eval .= "['$key']";
        if( preg_match( "/^[0-9]$/", $key ) )
        {
            $key = ( Int ) $key;
        }
        if( count( $expl ) === 1 )
        {
            return( isset( $arr[$key] ) ? $arr[$key] : Null );
        } else {
            if( count( $expl ) === $i )
            {
                if( isset( $data[$key] ) )
                {
                    $data = $data[$key]; break;
                } else {
                    $data = isset( $arr[$key] ) ? $arr[$key] : Null;
                }
            } else {
                if( isset( $data[$key] ) )
                {
                    $data = $data[$key];
                } else {
                    $data = isset( $arr[$key] ) ? $arr[$key] : Null;
                }
            }
        }
    }
    return( $data );
    //return( eval( "return( isset( $eval ) ? $eval : Null );" ) );
}

?>