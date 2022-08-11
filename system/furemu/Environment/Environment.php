<?php

namespace Yume\Fure\Environment;
;
use Yume\Fure\IO;
use Yume\Fure\JSON;
use Yume\Fure\RegExp;

/*
 * Environment Class
 *
 * @package Yume\Fure\Environment
 */
abstract class Environment
{
    use \Yume\Fure\AoE\ITraits\Config;
    
    /*
     * The overall results of the captured variables.
     *
     * @access Public Static
     *
     * @values Array
     */
    public static Array $matchs = [];
    
    /*
     * The overall result of the variable after the value is validated.
     *
     * @access Public Static
     *
     * @values Array
     */
    public static Array $result = [];
    
    /*
     * Regular expression to capture variables by value type.
     *
     * @access Public Static
     *
     * @values Array
     */
    public static Array $regexp = [
        
        /*
         * Array variable.
         *
         * @example VAR=[ ...value ]
         * @example VAR={ ...value }
         */
        "Array" => "(\{.*\k{Distance}\})|(\[.*\k{Distance}\])",
        
        /*
         * Boolean variable.
         *
         * @example VAR=True
         * @example VAR=False
         */
        "Bool" => "(True|False)",
        
        /*
         * Int variable.
         *
         * @example VAR=1
         */
        "Int" => "([0-9]+)",
        
        /*
         * Null variable.
         *
         * @example VAR=
         * @example VAR=Null
         * @example VAR=None
         */
        "Null" => "(Null|None)*",
        
        /*
         * String variable.
         *
         * @example VAR=Value
         * @example VAR="Value"
         */
        "String" => "\".*\k{Distance}\"|([\S]+)"
        
    ];
    
    /*
     * Regular expression to find variable name and variable value.
     *
     * @access Public Static
     *
     * @values String
     */
    public static String $search = "/^(?:(?<Matched>(?<Name>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)((\:(?<Type>Array|Bool|Int|Null|String))*)([\s|\t]*)\=(?<Distance>[\s|\t]*)(?<Value>{})))$/ims";
    
    /*
     * Loading environment files.
     *
     * @access Public Static
     *
     * @return Void
     */
    public static function onload(): Void
    {
        // Reading environment file.
        self::search( IO\File::read( self::config( "path" ) ) );
        
        // Get environment flags lags.
        $skiped = self::config( "skiped" );
        $replace = self::config( "replace" );
        
        // Check if environment has prefix.
        if( $prefix = self::config( "prefix" ) )
        {
            // If environment prefix is invalid.
            if( RegExp\RegExp::test( "/^(?:(?<Prefix>[A-Z_\x80-\xff][A-Z0-9_\x80-\xff]*))$/", $prefix ) === False )
            {
                throw new EnvironmentError( $prefix, EnvironmentError::INVALID_PREFIX_NAME );
            }
        }
        
        foreach( self::$matchs As $name => $option )
        {
            try 
            {
                // Parse variable value.
                $env = self::convert( $option );
            }
            catch( JSON\JSONError $e )
            {
                throw new EnvironmentError( $name, EnvironmentError::INVALID_ARRAY_VALUE, $e );
            }
            
            // Check if the variable name is not capitalized.
            if( strtoupper( $name ) !== $name )
            {
                throw new EnvironmentError( $name, EnvironmentError::INVALID_NAME );
            }
            
            if( $option['type'] )
            {
                // If the value of the type variable is not equal to the regex type.
                if( $option['type'] !== $option['retype'] && $option['value'] !== "Null" && $option['value'] !== "None" )
                {
                    throw new EnvironmentError( [ $name, $option['type'], $option['retype'] ], EnvironmentError::INVALID_VALUE_TYPE );
                }
            }
            
            // Check if the variable name already exists in the superglobal $_ENV.
            if( isset( $_ENV[$name] ) )
            {
                // Checks whether overwriting the super global $_ENV variable is allowed.
                if( $replace === False )
                {
                    throw new EnvironmentError( $name, EnvironmentError::DUPLICATE_SUPER_GLOBAL );
                }
            }
            
            // Adding a variable to the $_ENV superglobal.
            $_ENV[$name] = $env;
            
            // If the constant name has been defined.
            if( defined( $name ) )
            {
                // If skip is not allowed.
                if( $skiped === False )
                {
                    throw new EnvironmentError( $name, EnvironmentError::DUPLICATE_CONSTANT );
                }
            }
            else {
                
                // Define super global constant.
                define( $prefix ? $name = f( "{}_{}", $prefix, $name ) : $name, $env );
            }
        }
    }
    
    /*
     * Mapping configuration.
     *
     * @access Public Static
     *
     * @params Array $configs
     *
     * @return Array
     */
    public static function mapping( Array $configs ): Array
    {
        foreach( $configs As $key => $val )
        {
            if( is_array( $val ) )
            {
                $configs[$key] = self::mapping( $val );
            } else {
                $configs[$key] = envable( $val );
            }
        }
        return( $configs );
    }
    
    protected static function convert( Array $option ): Mixed
    {
        return( match( $option['retype'] )
        {
            // Decode json string value.
            "Array" => JSON\JSON::decode( $option['value'], True ),
            
            // Convert string value to boolean.
            "Bool" => $option['value'] === "True" ? True : False,
            
            // Convert string value to int.
            "Int" => ( Int ) $option['value'],
            
            // Convert string value to null.
            "Null",
            "None" => Null,
            
            // String only.
            default => RegExp\RegExp::replace( "/^\"([^\"]*)\"$/", $option['value'], "$1" )
        });
    }
    
    /*
     * Looking for variables.
     *
     * @access Protected Static
     *
     * @params String $loaded
     *
     * @return Array
     */
    protected static function search( String $loaded )
    {
        // Delete all variable comments.
        $loaded = RegExp\RegExp::replace( "/(?:(?<=\s)\#([^\n\r]*)[\n\r]*)/", $loaded, "" );
        
        foreach( self::$regexp As $type => $retype )
        {
            // Remove all caught variables.
            $loaded = RegExp\RegExp::replace( f( self::$search, $retype ), $loaded, function( $m ) use( $type )
            {
                // Clean up match results.
                $match = RegExp\RegExp::clear( $m );
                
                // Add to queue.
                self::$matchs[$match['Name']] = [
                    "matched" => $match['Matched'],
                    "retype" => $type,
                    "type" => $match['Type'],
                    "value" => $match['Value']
                ];
            });
        }
        
        return( self::$matchs );
    }
    
}

?>