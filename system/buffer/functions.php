<?php

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\RegExp;
use Yume\Kama\Obi\Sasayaki;
use Yume\Kama\Obi\Trouble;

/*
 * Retrieve element values using dot as array separator.
 *
 * @params Array|String $refs
 * @params Array|ArrayAccess $data
 *
 * @return Mixed
 */
function ify( Array | String $refs, Array | ArrayAccess $data ): Mixed
{
    if( is_string( $refs ) )
    {
        // Encodes each character inside [].
        $refs = RegExp\RegExp::replace( "/(?:\[([^\]]*)\])/", $refs, fn( $m ) => f( ".b64_{}", base64_encode( $m[1] ) ) );
        
        // Split string with period.
        $refs = explode( ".", $refs );
    }
    
    foreach( $refs As $key )
    {
        // Checks if the character contains only numbers.
        if( AoE\Numberable::is( $key ) )
        {
            // Parse string to int.
            $key = ( Int ) $key;
        } else {
            
            // Checks if the string is encoded text.
            if( RegExp\RegExp::test( "/^(?:b64_.*?)$/", $key ) )
            {
                // Decode BASE64 strings.
                $key = RegExp\RegExp::replace( "/^(?:b64_(.*?))$/", $key, fn( $m ) => base64_decode( $m[1] ) );
            }
        }
        if( isset( $stack ) )
        {
            if( isset( $stack[$key] ) )
            {
                $stack = $stack[$key];
            } else {
                throw is_string( $key ) ? new Trouble\KeyError( $key ) : new Trouble\IndexError( $key );
            }
        } else {
            if( isset( $data[$key] ) )
            {
                $stack = $data[$key];
            } else {
                throw is_string( $key ) ? new Trouble\KeyError( $key ) : new Trouble\IndexError( $key );
            }
        }
    }
    
    return( $stack );
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
    if( isset( $format[0] ) )
    {
        if( is_array( $format[0] ) )
        {
            $format = $format[0];
        }
    }
    return( RegExp\RegExp::replace( "/\{([^\}]*)\}/", $string, function() use( $format )
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
 * Shorthand format function name.
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
    $expl = explode( ".", RegExp\RegExp::replace( "/(?:\[([^\]]*)\])/", $config, fn( $m ) => f( ".b64_{}", base64_encode( $m[1] ) ) ) );
    
    // Create file name.
    $file = strtolower( $expl[0] );
    
    // Import configuration file.
    $configs = AoE\Package::import( format( "configs/{}", $file ), Trouble\ModuleError::CONFIG );
    
    // Unset first element.
    array_shift( $expl );
    
    if( count( $expl ) > 0 )
    {
        return( ify( $expl, $configs ) );
    }
    return( $configs );
}

?>