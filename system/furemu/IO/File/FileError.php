<?php

namespace Yume\Kama\Obi\IO\File;

use Yume\Kama\Obi\IO;

/*
 * FileError
 *
 * FileError will only be thrown
 * if there is an error in the file.
 *
 * @extends Yume\Kama\Obi\IO\IOError
 *
 * @package Yume\Kama\Obi\IO\File
 */
class FileError extends IO\IOError
{
	
	/*
	 * If the file is not executeable.
	 *
	 * @access Public Static
	 *
	 * @values Int
	 */
	public const NOT_EXECUTEABLE = 9876;
	
	/*
	 * If the file is not file.
	 *
	 * @access Public Static
	 *
	 * @values Int
	 */
	public const NOT_FILE = 9877;
	
	/*
	 * If the file is not found.
	 *
	 * @access Public Static
	 *
	 * @values Int
	 */
	public const NOT_FOUND = 9878;
	
	/*
	 * If the file is not readable.
	 *
	 * @access Public Static
	 *
	 * @values Int
	 */
	public const NOT_READABLE = 9879;
	
	/*
	 * If the file is not writeable.
	 *
	 * @access Public Static
	 *
	 * @values Int
	 */
	public const NOT_WRITEABLE = 9880;
	
	/*
	 * @inherit Yume\Kama\Obi\Trouble\TroubleError
	 *
	 */
	protected Array $flags = [
		self::NOT_EXECUTEABLE => "File {} is not executeable.",
		self::NOT_FILE => "File {} is a directory.",
		self::NOT_FOUND => "File {} could not be found.",
		self::NOT_READABLE => "File {} is not readable.",
		self::NOT_WRITEABLE => "File {} is not writable."
	];
	
}

?>