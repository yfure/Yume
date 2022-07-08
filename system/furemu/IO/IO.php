<?php

namespace Yume\Kama\Obi\IO;

/*
 * IO
 *
 * @package Yume\Kama\Obi\IO
 */
abstract class IO
{
	
	/*
	 * Check if file or directory is executable.
	 *
	 * @access Public
	 *
	 * @params String $file
	 *
	 * @return Bool
	 */
	public static function executeable( String $file ): Bool
	{
		return( is_executable( path( $file ) ) );
	}
	
	/*
	 * Check if file or directory is readable.
	 *
	 * @access Public
	 *
	 * @params String $file
	 *
	 * @return Bool
	 */
	public static function readable( String $file ): Bool
	{
		return( is_readable( path( $file ) ) );
	}
	
	/*
	 * Check if file or directory is writeable.
	 *
	 * @access Public Static
	 *
	 * @params String $file
	 *
	 * @return Bool
	 */
	public static function writeable( String $file )
	{
		return( is_writeable( path( $file ) ) );
	}
	
}

?>