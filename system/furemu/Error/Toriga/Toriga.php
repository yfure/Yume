<?php

namespace Yume\Kama\Obi\Error\Toriga;

use Yume\Kama\Obi\Trouble;

abstract class Toriga
{
    public static function handler( Int $errcode, String $errmesg, String $errfile, Int $errline ): Void
    {
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
        throw new Trouble\TriggerError( $errmesg, $errfile, $errlevl, $errline, $errcode );
    }
}

?>