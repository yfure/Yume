<?php

/*
 * Application configuration.
 *
 * @return Yume\Fure\Config\Config
 */
return(
	new Yume\Fure\Config\Config( "App", [
		
		/*
		 * Application name.
		 *
		 * @default Yume
		 */
		"name" => env( "APP_NAME", "Yume" ),
		
		/*
		 * Application author name.
		 *
		 * @default hxAri
		 */
		"author" => env( "APP_AUTHOR", "Ari Setiawan (hxAri)" ),
		
		/*
		 * Application domain name.
		 *
		 * @default 
		 */
		"domain" => env( "APP_DOMAIN", "example" ),
		
		/*
		 * Application issues link.
		 *
		 * @default https://github.com/yfure/Yume/issues
		 */
		"issues" => env( "APP_ISSUES", "https://github.com/yfure/Yume/issues" ),
		
		/*
		 * Application source link.
		 *
		 * @default https://github.com/yfure/Yume
		 */
		"source" => env( "APP_SOURCE", "https://github.com/yfure/Yume" ),
		
		/*
		 * Application license name.
		 *
		 * @always MIT
		 */
		"license" => "MIT",
		
		/*
		 * Application version.
		 *
		 * @default None
		 */
		"version" => env( "APP_VERSION", "None" ),
		
		/*
		 * Inheritable configuration.
		 *
		 */
		"[inherit]" => []
		
	])
);

?>