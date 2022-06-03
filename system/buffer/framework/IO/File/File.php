<?php

namespace Yume\Kama\Obi\IO\File;

use function Yume\Func\path;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Reflection;
use Yume\Kama\Obi\Trouble;

use DateTime;

/*
 * File utility class.
 *
 * @package Yume\Kama\Obi\IO\File
 */
abstract class File
{
    
    /*
     * Get file sizes
     *
     * @access Public, Static
     *
     * @params String <file>
     *
     * @return String, Int
     */
    public static function size( ? String $file = Null ): Int | String
    {
        return( self::handle( $file, function( String $file )
        {
            return( filesize( $file ) );
        }));
    }
    
    public static function time( String $file, Bool $dateTime = False ): Int | DateTime
    {
        return( self::handle( $file, function( String $file ) use( $dateTime )
        {
            if( $dateTime !== False )
            {
                return( clone AoE\App::$object->dateTime )->setTimestamp( filemtime( $file ) );
            }
            return( filemtime( $file ) );
        }));
    }
    
    public static function type( String $file )
    {
        
    }
    
    public static function read( String $file, String $fmode = "rb" )
    {
        // Get file size.
        $fsize = self::size( $file );
        
        return( self::handle( $file, catch: self::error(), handler: function( String $file ) use( $fsize, $fmode )
        {
            
            // File open handler.
            $fopen = fopen( $file, $fmode );
            
            // 2mb Chunks.
            $block = 2 << 20;
            
            $fsent = 0;
            $fread = "";
            
            while( $fsent < $fsize )
            {
                $fread .= fread( $fopen, $block );
                $fsent += $block;
            }
            
            // Close resource.
            fclose( $fopen );
            
            return( $fread );
            
        }));
    }
    
    public static function write( String $file, String $fdata, String $fmode = "a" ): Void
    {
        // File open handler.
        $fopen = fopen( $file, $fmode );
        
        // Write resource.
        fwrite( $fopen, $fdata );
        
        // Close resource.
        fclose( $fopen );
        
    }
    
    public static function error(): Callable
    {
        return( function( String $file )
        {
            throw new Trouble\Exception\IOError( "The \"$file\" file was not found or may have been deleted." );
        });
    }
    
    public static function handle( ? String $file, Callable $handler, Callable | String | Null | Bool | Int $catch = Null )
    {
        // Clears file status cache.
        clearstatcache();
        
        if( is_file( $file = path( base: $file ) ) )
        {
            return( Reflection\ReflectionFunction::invoke( $handler, [$file] ) );
        }
        if( is_callable( $catch ) )
        {
            return( Reflection\ReflectionFunction::invoke( $catch, [$file] ) );
        }
        return( False );
    }
    
}

?>