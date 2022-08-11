<?php

use Yume\Fure\AoE;
use Yume\Fure\Environment;
use Yume\Fure\Error;
use Yume\Fure\HTTP;
use Yume\Fure\IO;
use Yume\Fure\RegExp;
use Yume\Fure\Sasayaki;
use Yume\Fure\Translator;
use Yume\Fure\View;


/*
 * @inherit Yume\Fure\AoE\Arrayer
 *
 */
function ify( Array | String $refs, Array | ArrayAccess $data ): Mixed
{
    return( AoE\Arrayer::ify( $refs, $data ) );
}

/*
 * Get fullpath name or remove basepath name.
 *
 * @params String $path
 *
 * @return String
 */
function path( ? String $path = Null, Bool $remove = False ): String
{
    if( $path !== Null && $remove )
    {
        return( str_replace( RegExp\RegExp::replace( "/\//", BASE_PATH, DIRECTORY_SEPARATOR ), "", $path ) );
    }
    return( RegExp\RegExp::replace( "/\//", f( "{}/{}", BASE_PATH, $path ), DIRECTORY_SEPARATOR ) );
}

/*
 * Displays the contents of the view or component.
 *
 * @params String $path
 * @params Array|Yume\Fure\AoE\Data $data
 *
 * @return String
 */
function view( String $path, Array | AoE\Data $data = [] )//: String
{
    // This function under development!
}

/*
 * @inherit Yume\Fure\AoE\Stringer
 *
 */
function f( String $string, Mixed ...$format ): String
{
    return( call_user_func_array( "Yume\Fure\AoE\Stringer::format", [ $string, ...$format ] ) );
}

/*
 * @inherit Yume\Fure\IO\Path\PathAbstract
 *
 */
function ls( String $path ): Array | Bool
{
    return( IO\Path::ls( $path ) );
}

/*
 * @inherit Yume\Fure\IO\Path\PathAbstract
 *
 */
function tree( String $path, String $parent = "" ): Array | False
{
    return( IO\Path::tree( $path, $parent ) );
}

/*
 * Get environment variable value.
 *
 * @params String $env
 *
 * @return Mixed
 */
function env( String $env ): Mixed
{
    if( isset( $_ENV[$env] ) )
    {
        return( $_ENV[$env] );
    }
    throw new Environment\EnvironmentError( f( "No environment named \"{}\"", $env ), 0 );
}

function envable( Mixed $value ): Mixed
{
    if( is_string( $value ) )
    {
        if( $match = RegExp\RegExp::match( "/^\@\^(?<env>[^\$]+)\\$$/", $value ) )
        {
            return( env( $match['env'] ) );
        }
    }
    return( $value );
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
    $configs = AoE\Package::import( f( "configs/{}", $file ), Error\ModuleError::CONFIG );
    
    // Unset first element.
    array_shift( $expl );
    
    if( count( $expl ) > 0 )
    {
        if( is_string( $ify = ify( $expl, $configs ) ) )
        {
            $ify = envable( $ify );
        }
        return( $ify );
    }
    return( $configs );
}

function translate( String $key, ? String $lang = Null ): ? String
{
    if( $lang !== Null )
    {
        
    }
    return( Translator\Translator::translate( $key ) );
}

?>