<?php

namespace Yume\Fure\Error;

use Throwable;

/*
 * ExtensionError
 *
 * An exception will be thrown when any extension is not installed or not loaded.
 *
 * @package Yume\Fure\Error
 */
class ExtensionError extends BaseError
{
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    public function __construct( ? String $extension, Int $code = 0, ? Throwable $prev = Null )
    {
        parent::__construct( f( "Extension {} is not loaded or not installed.", $extension ), $code, $prev );
    }
}

?>