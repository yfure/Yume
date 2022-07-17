<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\RegExp;

/*
 * Replaceable
 *
 * @package Yume\Kama\Obi\AoE
 */
final class Replaceable
{
    
    public Readonly Array $tree;
    public String $readed = "";
    
    public function __construct()
    {
        $this->loop( $this->tree = [ "system" => tree( "/system" ) ] );
    }
    
    /*
     * Looping arrays.
     *
     * @access Public
     *
     * @params Array $array
     * @params String $in
     *
     * @return Void
     */
    public function loop( Array $array, String $in = "" )
    {
        // Eaching arrays.
        foreach( $array As $i => $v )
        {
            // If the folder has a lot of content.
            if( is_array( $v ) )
            {
                // Repeat again.
                $this->loop( $v, f( "{}/{}", $in, $i ) );
            } else {
                
                // Create file name.
                $fname = f( "{}/{}", $in, $v );
                
                // Get file contents.
                $fdata = IO\File::read( $fname );
                
                //$this->bund( $fname, $fdata );
                $this->repl( $fname, $fdata );
            }
        }
    }
    
    /*
     * I Don't know why :|
     *
     * @access Public
     *
     * @params String $fname
     * @params String $fdata
     *
     * @return Void
     */
    public function bund( String $fname, String $fdata )
    {
        // Remove the extension name and replace the filename slash to a period.
        $fname = $fname = RegExp\RegExp::replace( "/(?:(\/|\.php\b))/", RegExp\RegExp::replace( "/(?:(^\/))/", $fname, "" ), fn( $m ) => $m[0] === "/" ? "." : "" );
        
        // ...
        $fstrip = "";
        
        // Get the new filename length.
        $length = strlen( $fname );
        
        for( $i = 0; $i < $length; $i++ )
        {
            $fstrip .= "-";
        }
        
        // Add to stack of read files.
        $this->readed .= f( "\n//\x20{}\n//\x20{}\n//\x20{}{}", $fstrip, $fname, $fstrip, RegExp\RegExp::replace( "/(?:(^\<\?php|^\?\>|\t))/m", $fdata, fn( $m ) => $m[0] === "\t" ? "\x20\x20\x20\x20" : "" ) );
    }
    
    /*
     * Replace content file with regular expression.
     *
     * @access Public
     *
     * @params String $fname
     * @params String $fdata
     *
     * @return Void
     */
    public function repl( String $fname, String $fdata )
    {
        // Compose regular expression.
        $regexp = f( "/(?:(?<RegExp>({})))/imJ", implode( "|", [ "(?<Search>\b(Public|Private|Protected)\:[\s]+)" ] ) );
        
        // Start replacing.
        $replace = RegExp\RegExp::replace( $regexp, $fdata, function( $m ) use( $fname, $fdata )
        {
            return( RegExp\RegExp::replace( "/\:/i", $m[0], "" ) );
        });
        
        if( $replace !== $fdata )
        {
            //IO\File::write( $fname, $replace, "w" );
        }
    }
}

?>