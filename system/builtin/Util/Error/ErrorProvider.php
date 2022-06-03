<?php

namespace Yume\Kama\Obi\Error;

use function Yume\Func\path;

use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\AoE;

/*
 * ErrorProvider utility class.
 *
 * @package Yume\Kama\Obi\Error
 */
abstract class ErrorProvider
{
    
    /*
     * @inheritdoc ErrorInterface
     *
     */
    public static function write( String $dir, Array $error ): Void
    {
        $error['timestamp'] = AoE\App::$object->dateTime->getTimestamp();
        
        // If the error store has not been created. **/
        if( file_exists( path( log: $dir ) ) === False )
        {
            // Creating an error log directory. **/
            mkdir( path( log: $dir ) );
        }
        
        // Parse error to tree string.
        $data = AoE\Tree::tree( $error, type: AoE\Tree::POINT );
        
        // Create file name by date time.
        $path = path( log: "{$dir}/" );
        
        // Write file.
        IO\File\File::write( $path . AoE\App::$object->dateTime->format( "d.M-Y.\l\o\g" ), $data, "a" );
        
    }
    
}

?>