<?php

namespace Yume\Kama\Obi\Storage\IO;

use function Yume\Func\path;

use Yume\Kama\Obi\Exception;

class Fairu
{
    
    protected $file;
    
    public function __construct( String $file )
    {
        if( file_exists( path( base: $this->file = $file ) ) === False )
        {
            throw new Exception\IOException( "Cannot find file or directory {$file}" );
        }
    }
    
    public function __toString(): String
    {
        return( $this->reader() );
    }
    
    /*
     * Return the named resource value, specified by filename, to the stream.
     *
     * @access Public
     *
     * @params String <mode>
     *
     * @return Mixed
     */
    public function fopen( String $mode = "a+" ): Mixed
    {
        
        /*
         * A list of possible modes for fopen.
         *
         * @mode Array
         */
        $modes = [
            "r",
            "r+",
            "w",
            "w+",
            "a",
            "a+",
            "x",
            "x+",
            "c",
            "c+",
            "e"
        ];
        
        foreach( $modes As $mod )
        {
            if( $mod === $mode )
            {
                return( fopen( path( base: $this->file ), $mode ) );
            }
        }
        throw new Exception( "File open invalid mode {$mode}" );
    }
    
    /*
     * Gets file size.
     *
     * @access Public
     *
     * @return Int, False
     */
    public function fisize(): Int | False
    {
        return( filesize( path( base: $this->file ) ) );
    }
    
    /*
     * Gets file modification time.
     *
     * @access Public
     *
     * @return Int, False
     */
    public function fitime(): Int | False
    {
        return( filemtime( path( base: $this->file ) ) );
    }
    
    /*
     * Binary-safe file read.
     *
     * @access Public
     *
     * @return String
     */
    public function reader(): String
    {
        // Text readed.
        $read = "";
        
        if( $this->fisize() !== 0 )
        {
            // Opening file.
            $file = $this->fopen( "r" );
            
            while( feof( $file ) !== True )
            {
                $read .= fread( $file, $this->fisize() );
            }
            
            // Closing File.
            fclose( $file );
        }
        return( $read );
    }
    
    /*
     * Binary-safe file write.
     *
     * @access Public
     *
     * @return Static
     */
    public function writer( String $cont, String $mode = "a+" ): Static
    {
        // Opening file.
        $file = $this->fopen( $mode );
        
        // Writing file.
        fwrite( $file, $cont );
        
        // Closing File.
        fclose( $file );
        
        return( $this );
    }
    
}

?>