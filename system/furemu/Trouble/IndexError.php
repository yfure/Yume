<?php

namespace Yume\Kama\Obi\Trouble;

/*
 * Trouble IndexError
 *
 * IndexError thrown when index not found.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class IndexError extends TroubleError
{
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    public function __construct( ? Int $index = 0, Int $code = 0, ? Throwable $prev = Null )
    {
        parent::__construct( f( "Index {} out of range.", $index ), $code, $prev );
    }
}

?>