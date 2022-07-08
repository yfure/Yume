<?php

namespace Yume\Kama\Obi\IO\File;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\IO;

use DateTime;

/*
 * File
 *
 * @package Yume\Kama\Obi\IO\File
 */
class File implements FileInterface
{
	
	/*
	 * File name
	 *
	 * @access Public Readonly
	 *
	 * @values String
	 */
	public Readonly String $fname;
	
	/*
	 * File extension type.
	 *
	 * @access Public Readonly
	 *
	 * @values String
	 */
	public Readonly String $ftype;
	
}

?>