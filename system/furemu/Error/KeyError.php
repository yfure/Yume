<?php

namespace Yume\Fure\Error;

/*
 * Error KeyError
 *
 * KeyError will be thrown if key does not exist.
 *
 * @package Yume\Fure\Error
 */
class KeyError extends BaseError
{
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    public function __construct( ? String $key = Null, Int $code = 0, ? Throwable $prev = Null )
    {
        parent::__construct( f( "Key {} undefined.", $key ), $code, $prev );
    }
}

?>