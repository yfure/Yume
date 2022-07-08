<?php

namespace Yume\Kama\Obi\IO;

use Yume\Kama\Obi\Trouble;

/*
 * IOError
 *
 * IOError will only be thrown if there
 * is an error in the input or output.
 *
 * @extends Yume\Kama\Obi\Trouble\TroubleError
 *
 * @package Yume\Kama\Obi\IO
 */
class IOError extends Trouble\TroubleError {}

?>