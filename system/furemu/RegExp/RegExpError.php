<?php

namespace Yume\Fure\RegExp;

use Yume\Fure\Error;

/*
 * RegExpError
 *
 * @extends Yume\Fure\Error\TypeError
 *
 * @package Yume\Fure\RegExp
 */
class RegExpError extends Error\TypeError
{
    public const PREG_BACKTRACK_LIMIT_ERROR = 2;
    public const PREG_BAD_UTF8_ERROR = 4;
    public const PREG_BAD_UTF8_OFFSET_ERROR = 5;
    public const PREG_INTERNAL_ERROR = 1;
    public const PREG_JIT_STACKLIMIT_ERROR = 6;
    public const PREG_NO_ERROR = 0;
    public const PREG_RECURSION_LIMIT_ERROR = 3;
}

?>