<?php

namespace Yume\Util\Error;

use function Yume\Func\path;

use Yume\Util\IO;
use Yume\Util\Himei;

/*
 * ErrorProvider utility class.
 *
 * @package Yume\Util\Error
 */
abstract class ErrorProvider
{
    
    /*
     * @inheritdoc ErrorInterface
     *
     */
    public static function write( String $dir, Array $error ): Void
    {
        $error['timestamp'] = Himei\Application::$object->dateTime->getTimestamp();
        
        // If the error store has not been created. **/
        if( file_exists( path( log: $dir ) ) === False )
        {
            // Creating an error log directory. **/
            mkdir( path( log: $dir ) );
        }
        
        // Parse error to tree string.
        $data = Himei\Tree::tree( $error, type: Himei\Tree::POINT );
        
        // Create file name by date time.
        $path = path( log: "{$dir}/" );
        
        // Write file.
        IO\File\File::write( $path . Himei\Application::$object->dateTime->format( "d.M-Y.\l\o\g" ), $data, "a" );
        
    }
    
}

?>
