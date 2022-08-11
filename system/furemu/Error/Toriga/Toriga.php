<?php

namespace Yume\Fure\Error\Toriga;

use Yume\Fure\Error;
use Yume\Fure\Logger;

/*
 * Toriga (Trigger)
 *
 * @package Yume\Fure\Error\Toriga
 */
abstract class Toriga
{
    /*
     * Trigger handler.
     *
     * @access Public Static
     *
     * @params Int $errcode
     * @params String $errmesg
     * @params String $errfile
     * @params Int $errline
     *
     * @return Void
     */
    public static function handler( Int $errcode, String $errmesg, String $errfile, Int $errline ): Void
    {
        // Getting error level.
        $errlevl = match( $errcode )
        {
            E_ERROR => "E_ERROR",
            E_WARNING => "E_WARNING",
            E_PARSE => "E_PARSE",
            E_NOTICE => "E_NOTICE",
            E_CORE_ERROR => "E_CORE_ERROR",
            E_CORE_WARNING => "E_CORE_WARNING",
            E_COMPILE_ERROR => "E_COMPILE_ERROR",
            E_COMPILE_WARNING => "E_COMPILE_WARNING",
            E_USER_ERROR => "E_USER_ERROR",
            E_USER_WARNING => "E_USER_WARNING",
            E_USER_NOTICE => "E_USER_NOTICE",
            E_STRICT => "E_STRICT",
            E_RECOVERABLE_ERROR => "E_RECOVERABLE_ERROR",
            E_DEPRECATED => "E_DEPRECATED",
            E_USER_DEPRECATED => "E_USER_DEPRECATED",
            E_ALL => "E_ALL",
            default => "E_UNKNOWN"
        };
        
        // Wrire new error log.
        Logger\Logger::write( $errmesg, $errfile );
        
        // Throw new error.
        throw new Error\TriggerError( $errmesg, $errfile, $errlevl, $errline, $errcode );
    }
}

?>