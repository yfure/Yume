<?php

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\Sasayaki;
use Yume\Kama\Obi\Trouble;

/*
 * Retrieve element values using dot as array separator.
 *
 * @params Array|String $name
 * @params Array|ArrayAccess $array
 *
 * @return Mixed
 */
function ify( Array | String $name, Array | ArrayAccess $array ): Mixed
{
    /*
     * Split string with period.
     *
     * @values Array
     */
    $expl = is_array( $name ) ? $name : explode( ".", $name );
    
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
                    throw is_int( $key ) ? new Trouble\IndexError( $key ) : new Trouble\KeyError( $key );
                }
            } else {
                throw new Trouble\TypeError( f( "The value must contain an array, {} is given.", gettype( $key ) ) );
            }
        } else {
            if( isset( $array[$key] ) )
            {
                $data = $array[$key];
            } else {
                throw is_int( $key ) ? new Trouble\IndexError( $key ) : new Trouble\KeyError( $key );
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
 * @params String $path
 * @params Array|Yume\Kama\Obi\AoE\Hairetsu $data
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
 * Shorthand function name.
 *
 * @inherit f.format
 *
 */
function f( String $string, Mixed ...$format ): String
{
    return( call_user_func_array( "format", [ $string, ...$format ] ) );
}

/*
 * Lisy directory contents.
 *
 * @params String $dir
 *
 * @return Array|Null
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

function tree( String $path, String $parent = "" ): Array | False
{
    if( is_dir( path( $path ) ) )
    {
        $tree = [];
        $scan = ls( $path );
        
        foreach( $scan As $i => $file )
        {
            if( $rscan = tree( f( "{}/{}", $path, $file ) ) )
            {
                $tree[$file] = $rscan;
            } else {
                $tree[] = $file;
            }
        }
        return( $tree );
    }
    return( False );
}

function replace( String $path, Array $tree, Callable $replace ): Void
{
    foreach( $tree As $dir => $file )
    {
        if( is_string( $dir ) )
        {
            replace( f( "{}/{}", $path, $dir ), $file, $replace );
        } else {
            if( is_file( $fpath = f( "{}/{}", $path, $file ) ) )
            {
                $fopen = fopen( $fpath, "rw" );
                $fread = fread( $fopen, 1024 );
                
                $frepl = call_user_func_array( $replace, [ $fpath, $fread ] );
                
                if( $fread !== $frepl )
                {
                    fwrite( $fopen, $frepl );
                }
                
                fclose( $fopen );
                
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