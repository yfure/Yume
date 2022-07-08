<?php

namespace Yume\Kama\Obi\IO\Path;

use Yume\Kama\Obi\IO;

/*
 * PathError
 *
 * DirectoryError will only be thrown
 * if there is an error in the directory.
 *
 * @extends Yume\Kama\Obi\IO\IOError
 *
 * @package Yume\Kama\Obi\IO\Path
 */
class PathError extends IO\IOError
{
	
	/*
	 * @inherit Yume\Kama\Obi\Trouble\TroubleError
	 *
	 */
	protected Array $flags = [
	];
	
}

?>