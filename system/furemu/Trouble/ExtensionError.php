<?php

namespace Yume\Kama\Obi\Trouble;

use Throwable;

/*
 * ExtensionError
 *
 * An exception will be thrown when any extension is not installed or not loaded.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class ExtensionError extends ThroubleError
{
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    public function __construct( ? String $extension, Int $code = 0, ? Throwable $prev = Null )
    {
        parent::__construct( f( "Extension {} is not loaded or not installed.", $extension ), $code, $prev );
    }
}

?>