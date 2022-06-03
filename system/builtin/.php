<?php

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\Sasayaki;
use Yume\Kama\Obi\Trouble;

/*
 * Retrieve element values using dot as array separator.
 *
 * @params String $name
 * @params Array, ArrayAccess $array
 *
 * @return Mixed
 */
function ify( String $name, Array | ArrayAccess $array ): Mixed
{
    /*
     * Split string with period.
     *
     * @values Array
     */
    $expl = explode( ".", $name );
    
    foreach( $expl As $i => $key )
    {
        if( preg_match( "/^[0-9]$/", $key ) )
        {
            $key = ( Int ) $key;
        }
        if( isset( $data ) )
        {
            if( is_array( $data ) )
            {
                if( isset( $data[$key] ) )
                {
                    $data = $data[$key];
                } else {
                    if( is_int( $key ) )
                    {
                        throw new Trouble\IndexError( key: $key, ref: "data" );
                    }
                    throw new Trouble\KeyError( key: $key, ref: "data" );
                }
            } else {
                throw new Trouble\ValueError( $key );
            }
        } else {
            if( isset( $array[$key] ) )
            {
                $data = $array[$key];
            } else {
                if( is_int( $key ) )
                {
                    throw new Trouble\IndexError( range: $key, ref: "data" );
                }
                throw new Trouble\KeyError( key: $key, ref: "data" );
            }
        }
    }
    
    return( $data );
}

/*
 * Get fullpath name.
 * Remove basepath name.
 *
 * @params String $path
 *
 * @return String
 */
function path( ? String $path = Null, Bool $remove = False ): String
{
    if( $path !== Null && $remove )
    {
        return( str_replace( preg_replace( "/\//", DIRECTORY_SEPARATOR, BASE_PATH ), "", $path ) );
    }
    return( preg_replace( "/\//", DIRECTORY_SEPARATOR, format( "{}/{}", BASE_PATH, $path ) ) );
}

/*
 * Displays the contents of the view or component.
 *
 * @params String <path>
 * @params Array, Yume\Kama\Obi\AoE\Hairetsu <data>
 *
 * @return String
 */
function view( String $path, Array | AoE\Hairetsu $data = [] ): String
{
    
    /*
     * Added Sasayaki extension if not exists.
     *
     * @extension Sasayaki\.php
     */
    $view = str_replace( [ "views.", "components." ], [ "/assets/views/", "/assets/views/components/" ], $path .= substr( $path, -10 ) !== "saimin.php" ? ".saimin.php" : "" );
    
    /*
     * Opening file.
     *
     * @instance IO\Fairu
     */
    $file = IO\File\File::read( $view );
    
    /*
     * Rendering template.
     *
     */
    return( new Sasayaki\SasayakiProvider( $file, $data ) );
}

/*
 * String formater.
 *
 * @params String $string
 * @params String $format
 *
 * @return String
 */
function format( String $string, Mixed ...$format ): String
{
    return( preg_replace_callback( "/\{([^\}]*)\}/", subject: $string, callback: function() use( $format )
    {
        // Statically Variable
        static $i = 0;
        
        if( isset( $format[$i] ) )
        {
            // Replace by $i.
            return( $format[$i++] );
        }
    }));
}

/*
 * Lisy directory contents.
 *
 * @params String <dir>
 *
 * @return Array, Null
 */
function ls( String $dir ): Array | Null
{
    if( is_dir( path( $dir ) ) )
    {
        // Scanning directory.
        $scan = scandir( path( $dir ) );
        
        // Computes the difference of arrays.
        $scan = array_diff( $scan, [ ".", ".." ] );
        
        // Sort an array by key in ascending order.
        ksort( $scan );
        
        return( $scan );
    }
    return Null;
}

function replace( Array $tree, Array $replace, String $parent = "" )
{
    foreach( $tree As $key => $val )
    {
        if( is_array( $val ) )
        {
            replace( $val, $replace, format( "{}/{}", $parent, $key ) );
        } else {
            
            $file = format( "{}/{}", $parent, $val );
            
            if( substr( $file, -4 ) === ".php" )
            {
                if( count( $replace ) !== 0 )
                {
                    
                    $fget = file_get_contents( path( $file ) );
                    
                    $frep = $fget;
                    
                    foreach( $replace As $from => $to )
                    {
                        $frep = str_replace( $from, $to, $frep );
                    }
                    
                    if( $fget !== $frep )
                    {
                        $fput = file_put_contents( path( $file ), $frep );
                    }
                    
                }
            }
        }
    }
}

/*
 * Get configuration file.
 *
 * @params String $config
 *
 * @return Mixed
 */
function config( String $config ): Mixed
{
    
    // Explode config name.
    $expl = explode( ".", $config );
    
    // Create file name.
    $file = strtolower( format( "{}.{}", $expl[0], "php" ) );
    
    // If the configuration file exists.
    if( file_exists( $file = path( format( "configs/{}", $file ) ) ) )
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
    
    throw new Trouble\ModuleError( module: $file, type: "config" );
}

?>