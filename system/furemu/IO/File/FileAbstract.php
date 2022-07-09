<?php

namespace Yume\Kama\Obi\IO\File;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\IO;

use DateTime;

/*
 * File
 *
 * @package Yume\Kama\Obi\IO\File
 */
abstract class FileAbstract
{
    
    public const SKIP_EMPTY_LINE = 7829;
    
    /*
     * Check if file is exists.
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return Bool
     */
    public static function exists( String $file ): Bool
    {
        return( is_file( path( $file ) ) );
    }
    
    /*
     * Read the contents of the file.
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return String
     */
    public static function read( String $file ): String
    {
        // Check if the filename is a directory.
        if( IO\Path::exists( $file ) )
        {
            throw new FileError( $file, FileError::NOT_FILE );
        }
        
        // Check if such a directory exists.
        if( IO\Path::exists( $fpath = AoE\Stringable::pop( $file, "/" ) ) )
        {
            // Check if such directory is unreadable.
            if( IO\IO::readable( $fpath ) === False )
            {
                throw new IO\Path\PathError( $fpath, IO\Path\PathError::NOT_READABLE );
            }
            
            // Check if such a file exists.
            if( self::exists( $file ) )
            {
                // Check if such files are unreadable.
                if( IO\IO::readable( $file ) === False )
                {
                    throw new FileError( $file, FileError::NOT_READABLE );
                }
            }
            
            // Add prefix base path.
            $fname = path( $file );
            
            // Get file size.
            $fsize = ( $fsize = self::size( $file ) ) !== 0 ? $fsize : 13421779;
            
            // Open file.
            if( $fopen = fopen( $fname, "r" ) )
            {
                // File readed.
                $fread = "";
                
                while( feof( $fopen ) === False )
                {
                    // Binary-safe file read.
                    $fread .= fread( $fopen, $fsize );
                }
                
                // Closes an open file pointer.
                fclose( $fopen );
                
                return( $fread );
            }
            // Failed Open File {}
        }
        throw new IO\Path\PathError( $fpath, IO\Path\PathError::NOT_FOUND );
    }
    
    /*
     * Read file contents and split file contents with endline.
     *
     * @access Public Static
     *
     * @params String $file
     * @params Int $flags
     *
     * @return Array
     */
    public static function readline( String $file, Int $flags = 0 ): Array
    {
        // Reading file contents.
        $fread = self::read( $file );
        
        // Split file contents with end line.
        $fline = explode( "\n", $fread );
        
        switch( $flags )
        {
            // Remove or skip blank lines.
            case self::SKIP_EMPTY_LINE:
            
                // Mapping Lines.
                foreach( $fline As $i => $line )
                {
                    // Check if the line is empty.
                    if( $line === "" )
                    {
                        // Destroy the line.
                        unset( $fline[$i] );
                    }
                }
                break;
        }
        
        return( $fline );
    }
    
    /*
     * Get file size.
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return String|Int
     */
    public static function size( String $file ): Int | String
    {
        return( filesize( path( $file ) ) );
    }
    
    /*
     * Get DateTime class instance from file.
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return DateTime
     */
    public static function time( String $file ): DateTime
    {
        // Get timestamp value from file.
        $time = filemtime( path( $file ) );
        
        // Clone instance of DateTime Runtime class.
        $date = ( clone AoE\Runtime::$app->object->dateTime )->setTimestamp( $time );
        
        // Return DateTime instance.
        return( $date );
    }
    
    /*
     * Remove file.
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return Bool
     */
    public static function unlink(): Bool
    {
        return( unlink( path( $file ) ) );
    }
    
    /*
     * Write or create a new file.
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return Bool
     */
    public static function write( String $file, ? String $fdata = Null, String $fmode = "w" ): Void
    {
        // Check if the filename is a directory.
        if( IO\Path::exists( $file ) )
        {
            throw new FileError( $file, FileError::NOT_FILE );
        }
        
        // Check if such a directory exists.
        if( IO\Path::exists( $fpath = AoE\Stringable::pop( $file, "/" ) ) )
        {
            // Check if such directory is unwriteable.
            if( IO\IO::writeable( $fpath ) === False )
            {
                throw new IO\Path\PathError( $fpath, IO\Path\PathError::NOT_WRITEABLE );
            }
            
            // Check if such a file exists.
            if( self::exists( $file ) )
            {
                // Check if such files are unwriteable.
                if( IO\IO::writeable( $file ) === False )
                {
                    throw new FileError( $file, FileError::NOT_WRITEABLE );
                }
            }
            
            // Add prefix base path.
            $fname = path( $file );
            
            // File contents.
            $fdata = $fdata ? $fdata : "";
            
            // Open file.
            if( $fopen = fopen( $fname, $fmode ) )
            {
                // Binary-safe file write.
                fwrite( $fopen, $fdata );
                
                // Closes an open file pointer.
                fclose( $fopen );
            } else {
                // Failed write file.
            }
        } else {
            throw new IO\Path\PathError( $fpath, IO\Path\PathError::NOT_FOUND );
        }
    }

}

?>