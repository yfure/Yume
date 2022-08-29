<?php

namespace Yume\Fure\View;

use Yume\Fure\AoE;
use Yume\Fure\IO;
use Yume\Fure\RegExp;

use Stringable;
use Throwable;

/*
 * View
 *
 * @package Yume\Fure\View
 */
abstract class View
{
    
    /*
     * Format cachec loaded.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const F_CACHE_LOADED = 7636;
    
    /*
     * Format cachec parsed.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const F_CACHE_PARSED = 7868;
    
    use \Yume\Fure\AoE\ITraits\Config;
    
    /*
     * Check if the view file has been cached.
     *
     * @access Public Static
     *
     * @params String $view
     * @params Int $flags
     *
     * @return Bool
     */
    public static function cached( String $view ): Bool
    {
        // Check if the cache file exists.
        if( self::exists( $view, self::F_CACHE_LOADED ) )
        {
            // Check if cache files are the same size.
            if( IO\File::size( self::format( $view, self::F_CACHE_LOADED ) ) === IO\File::size( self::format( $view ) ) )
            {
                // Check if cache files have the same content.
                return( self::reader( $view, self::F_CACHE_LOADED ) === self::reader( $view ) );
            }
        }
        return( False );
    }
    
    /*
     * Check if the view file has been parsed.
     *
     * @access Public Static
     *
     * @params String $view
     *
     * @return Bool
     */
    public static function parsed( String $view ): Bool
    {
        return( self::exists( $view, self::F_CACHE_PARSED ) );
    }
    
    /*
     * Check if the view file exists.
     *
     * @access Public Static
     *
     * @params String $view
     * @params Int $flags
     *
     * @return Bool
     */
    public static function exists( String $view, Int $flags = 0 ): Bool
    {
        return( IO\File::exists( self::format( $view, $flags ) ) );
    }
    
    /*
     * Format file view name.
     *
     * @access Public Static
     *
     * @params String $view
     * @params Int $flags
     *
     * @return String
     */
    public static function format( String $view, Int $flags = 0 ): String
    {
        // View path selection.
        $path = match( $flags )
        {
            // View cached.
            self::F_CACHE_LOADED => self::config( "cache.loaded" ),
            
            // View cache parsed.
            self::F_CACHE_PARSED => self::config( "cache.parsed" ),
            
            // View.
            default => self::config( "save.path" )
        };
        return( f( $path, $view ) );
    }
    
    /*
     * Read view contents.
     *
     * @access Public Static
     *
     * @params String $view
     * @params Int $flags
     *
     * @return String
     */
    public static function reader( String $view, Int $flags = 0 ): String
    {
        try
        {
            return( IO\File::read( self::format( $view, $flags ) ) );
        }
        catch( IO\IOError $e )
        {
            throw new ViewError( $view, ViewError::READ_ERROR, $e );
        }
    }
    
    /*
     * Create or overwrite view file.
     *
     * @access Public Static
     *
     * @params String $view
     * @params String $content
     * @params Int $flags
     *
     * @return Void
     */
    public static function writer( String $view, String $content, Int $flags = 0 ): Void
    {
        try {
            IO\File::write( self::format( $view, $flags ), $content );
        }
        catch( IO\IOError $e )
        {
            throw new ViewError( $view, ViewError::SAVE_ERROR, $e );
        }
    }
    
}

?>