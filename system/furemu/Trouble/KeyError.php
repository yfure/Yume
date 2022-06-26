<?php

namespace Yume\Kama\Obi\Trouble;

/*
 * Trouble KeyError
 *
 * KeyError will be thrown if key does not exist.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class KeyError extends TroubleError
{
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    public function __construct( ? String $key = Null, Int $code = 0, ? Throwable $prev = Null )
    {
        parent::__construct( f( "Key {} undefined.", $key ), $code, $prev );
    }
}

?>