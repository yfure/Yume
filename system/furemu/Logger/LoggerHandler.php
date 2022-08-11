<?php

namespace Yume\Fure\Logger;

use Yume\Fure\AoE;
use Yume\Fure\IO;
use Yume\Fure\Threader;

/*
 * LoggerHandler
 *
 * This logger class only use for write trigger emmited.
 *
 * @package Yume\Fure\Logger
 */
class LoggerHandler implements LoggerHandlerInterface
{
    
    /*
     * @inherit Yume\Fure\Logger\LoggerHandlerInterface
     *
     */
    public function write( String $message, String $file, String $save ): Void
    {
        // ....
        if( IO\Path::exists( $save ) === False )
        {
            IO\Path::mkdir( $save );
        }
        IO\File::write( f( "{}/{}.log", 
            $save, 
            md5( Threader\Runtime::$app->object->dateTime->format( "d.M-Y" ) ) ), 
            $this->format( $message, $file ), 
            "a" 
        );
    }
    
    /*
     * Create logger format.
     *
     * @access Public
     *
     * @params String $message
     * @params String $file
     *
     * @return String
     */
    public function format( String $message, String $file ): String
    {
        return( f( "[{}][{}] {} {}\n", [
            
            // Get current timestamp.
            Threader\Runtime::$app->object->dateTime->getTimestamp(),
            
            // Get current time.
            Threader\Runtime::$app->object->dateTime->format( "H:i:s" ),
            
            $message,
            
            $file
            
        ]));
    }
    
}

?>