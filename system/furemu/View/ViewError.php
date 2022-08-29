<?php

namespace Yume\Fure\View;

use Yume\Fure\Error;

/*
 * ViewError
 *
 * @extends Yume\Fure\Error\TypeError
 *
 * @pacakge Yume\Fure\View
 */
class ViewError extends Error\TypeError
{
    public const COMPILE_ERROR = 7545;
    public const READ_ERROR = 7567;
    public const SAVE_ERROR = 7578;
}

?>