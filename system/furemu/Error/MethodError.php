<?php

namespace Yume\Fure\Error;

/*
 * MethodError
 *
 * @extends Yume\Fure\Error\TypeError
 *
 * @package Yume\Fure\Error
 */
class MethodError extends TypeError
{
    public const UNCALLABLE = 8853;
    public const UNDEFINED = 8964;
}

?>