<?php

namespace Yume\Fure\Logger;

use Yume\Fure\AoE;
use Yume\Fure\Reflector;
use Yume\Fure\Threader;

/*
 * Logger
 *
 * This logger class only use for write trigger emmited.
 *
 * @package Yume\Fure\Logger
 */
abstract class Logger
{
    
    /*
     * Logger handler.
     *
     * @access Protected Static
     *
     * @values Yume\Fure\Logger\LoggerHandlerInterface
     */
    protected static ? LoggerHandlerInterface $handler = Null;
    
    /*
     * Call logger handler class.
     *
     * @access Public Static
     *
     * @params String $message
     * @params String $file
     *
     * @return Void
     */
    public static function write( String $message, String $file = "" ): Void
    {
        if( self::$handler === Null )
        {
            self::$handler = Reflector\ReflectClass::instance( Threader\App::config( "logger[save.handler]" ) );
        }
        self::$handler->write( $message, path( $file !== "" ? $file : __FILE__, True ), Threader\App::config( "logger[save.path]" ) );
    }
    
}

?>