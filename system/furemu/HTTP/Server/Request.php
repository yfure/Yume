<?php

namespace Yume\Kama\Obi\HTTP\Server;

/*
 * Server Request
 *
 * @package Yume\Kama\Obi\HTTP\Server
 */
abstract class Request extends Server
{
	
	/*
	 * Return route of current page.
	 *
	 * @access Public, Static
	 *
	 * @return String
	 */
	public static function uri(): String
	{
		return( isset( $_SERVER['REQUEST_URI'] ) ? ( ( $r = rtrim( $_SERVER['REQUEST_URI'], "/" ) ) !== "" ? $r : "/" ) : "/" );
	}
	
	/*
	 * Return current page method or match current page method.
	 *
	 * @access Public, Static
	 *
	 * @params String, Null <match>
	 *
	 * @return String, Bool
	 */
	public static function method( ? String $match = Null ): Bool | String
	{
		if( $match !== Null )
		{
			return( in_array( self::method(), $split = explode( "|", $match ) ) );
		}
		return( $_SERVER['REQUEST_METHOD'] );
	}
	
}

?>