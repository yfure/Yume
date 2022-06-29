<?php

namespace Yume\Kama\Obi\Trouble;

usr Yume\Kama\Obi\RegExp;

/*
 * Trouble TriggerError
 *
 * The Trigger Error will only be thrown when the
 * Error Handler Function catches the emitted error.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class TriggerError extends TroubleError
{
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    public function __construct( String $errmesg, String $errfile, String $errlevl, Int $errline = 0,  Int $errcode = 0, ? Throwable $prev = Null )
    {
        
        // Set error type.
        $this->type = $errlevl;
        
        // Set error line.
        $this->line = $errline;
        
        // Set error code.
        $this->code = $errcode;
        
        // Set error file.
        $this->file = $errfile;
        
        // Set error message.
        $this->message = $message = RegExp\RegExp::replace( "/(?:(?<Function>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\((?<Parameter>[^\)]*)\))/", $errmesg, "f.$1" );
        
        parent::__construct( $message, $errcode, $prev );
        
    }
}

?>