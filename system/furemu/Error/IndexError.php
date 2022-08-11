<?php

namespace Yume\Fure\Error;

/*
 * Error IndexError
 *
 * IndexError thrown when index not found.
 *
 * @package Yume\Fure\Error
 */
class IndexError extends BaseError
{
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    public function __construct( ? Int $index = 0, Int $code = 0, ? Throwable $prev = Null )
    {
        parent::__construct( f( "Index {} out of range.", $index ), $code, $prev );
    }
}

?>