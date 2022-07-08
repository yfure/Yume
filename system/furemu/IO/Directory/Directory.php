<?php

namespace Yume\Kama\Obi\IO;

/*
 * Directory
 *
 * @package Yume\Kama\Obi\IO
 */
abstract class Directory
{
	
	/*
	 * Tells whether the filename is a directory.
	 *
	 * @access Public Static
	 *
	 * @params String $dir
	 *
	 * @return Bool
	 */
	public static function is( String $dir ): Bool
	{
		return( is_dir( path( $dir ) ) );
	}
	
}

?>