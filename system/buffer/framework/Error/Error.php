<?php

namespace Yume\Kama\Obi\Error;

use Yume\Kama\Obi\Logger;

abstract class Error
{
    
    public static function handler( Int $code, String $message, String $file, Int $line ): Void
    {
        echo $message . "<br/>\n";
        echo $line . "<br/>\n";
        echo path( $file, True ) . "<br/>\n";
    }
    
}

?>