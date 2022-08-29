<?php

use Yume\Fure\AoE;
use Yume\Fure\Environment;
use Yume\Fure\Error;
use Yume\Fure\HTTP;
use Yume\Fure\IO;
use Yume\Fure\Reflector;
use Yume\Fure\RegExp;
use Yume\Fure\Sasayaki;
use Yume\Fure\Threader;
use Yume\Fure\Translator;
use Yume\Fure\View;

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

function escape( String $string ): String
{
    
}

/*
 * Compare execution time.
 *
 * @params Float|String $start
 * @params Float|String $end
 *
 * @return Float|String
 */
function executionTimeCompare( Float | String $start, Float | String $end ): Float | String
{
    // Sum of all the values in the array.
    $timeStart = array_sum( explode( "\x20", $start ) );
    $timeEnd = array_sum( explode( "\x20", $end ) );
    
    // Format a number with grouped thousands.
    return( number_format( $timeEnd - $timeStart, 6 ) );
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
 * @inherit Yume\Fure\AoE\Arrayer
 *
 */
function ify( Array | String $refs, Array | ArrayAccess $data ): Mixed
{
    return( AoE\Arrayer::ify( $refs, $data ) );
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
 * Translate string into other language.
 *
 * @params String $key
 * @params String $lang
 *
 * @return String
 */
function translate( String $key, ? String $lang = Null ): ? String
{
    // ...
}

function translateable( String $value ): String
{
    // ...
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
 * Displays the contents of the view.
 *
 * @params String $view
 * @params Array|Yume\Fure\AoE\Data $data
 *
 * @return Void
 */
function view( String $view, Array | AoE\Data $data = [] ): Void
{
    if( View\View::cached( $view ) === False )
    {
        // Regular expression syntax.
        $regexp = "/(?:(?<syntax>\@[\s\n\t]*\{([\n\r\t\s]*)(?<code>.*?)([\n\r\t\s]*)\}[\s\n\t]*\;))/ms";
        
        // Read original view file.
        $loaded = View\View::reader( $view );
        
        // Replace all text enclosed in {}.
        $parsed = RegExp\RegExp::replace( $regexp, RegExp\RegExp::replace( "/\t/", $loaded, "\x20\x20\x20\x20" ), fn( Array $match ) => f( "<?php echo htmlspecialchars( \Yume\Fure\AoE\Stringer::parse( {} ) ); ?>", $match['code'] ) );
        
        // Create new cache.
        View\View::writer( $view, $loaded, View\View::F_CACHE_LOADED );
        View\View::writer( $view, $parsed, View\View::F_CACHE_PARSED );
    }
    
    // Turn on output buffering.
    ob_start();
    
    try {
        
        // If the data is a data object.
        if( $data Instanceof AoE\Data )
        {
            // Parse object data to array.
            $data = $data->__toArray();
        }
        
        // Extract array data to variable.
        extract( $data );
        
        // Include parsed view files.
        include path( View\View::format( $view, View\View::F_CACHE_PARSED ) );
    }
    catch( Throwable $e ) {
        
        // Get current buffer contents and delete current output buffer.
        $observe = ob_get_clean();
        
        // Rename view file to original filename.
        Reflector\ReflectProperty::setValue( $e, "file", View\View::format( $view ) );
        
        // Throw back exception.
        throw new View\ViewError( $view, View\ViewError::COMPILE_ERROR, $e );
    }
    
    // Flush the output buffer and turn off output buffering.
    ob_end_flush();
}

?>