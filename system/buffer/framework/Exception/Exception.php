<?php

namespace Yume\Kama\Obi\Exception;

use Yume\Kama\Obi\Logger;

use Throwable;

abstract class Exception
{
    
    public static function handler( Throwable $e ): Void
    {
        echo $e::class . "<br/>";
        echo $e->getMessage() . "<br/>";
        echo $e->getFile() . "<br/>";
        echo $e->getLine();
    }
    
}

?>