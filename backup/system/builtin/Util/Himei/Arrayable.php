<?php

namespace Yume\Kama\Obi\AoE;

use function Yume\Func\ify;

abstract class Arrayable
{
    
    /*
     * Retrieve element values using dot as array separator.
     *
     * @access Public, Static
     *
     * @params Array, String <str>
     * @params Array <arr>
     *
     * @return Mixed
     */
    public static function ify( Array | String $str, Array | DataInterface $arr ): Mixed
    {
        return( ify( $str, $arr ) );
    }
    
}

?>