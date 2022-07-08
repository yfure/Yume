<?php

namespace Yume\Kama\Obi\IO;

use Yume\Kama\Obi\Trouble;

/*
 * DirectoryError
 *
 * DirectoryError will only be thrown
 * if there is an error in the directory.
 *
 * @package Yume\Kama\Obi\IO
 */
class DirectoruError extends Trouble\TroubleError
{
	
	/*
	 * @inherit Yume\Kama\Obi\Trouble\TroubleError
	 *
	 */
	protected Array $flags = [
	];
	
}

?>