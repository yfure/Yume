<?php

namespace Yume\Kama\Obi\Error\Toriga;

abstract class Toriga
{
    
    public static function handler()
    {
        echo json_encode( func_get_args(), JSON_PRETTY_PRINT ) . "\n";
    }
    
}

?>