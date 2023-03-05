<?php

/*
 * Application configuration.
 *
 * @return Yume\Fure\Support\Config\Config
 */
return(
	new Yume\Fure\Support\Config\Config( "App", [
		
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
		 * Inheritable configuration.
		 *
		 */
		"[inherit]" => [],
		
		/*
		 * Command Register.
		 *
		 */
		"commands" => [
			Yume\Fure\CLI\Command\Help\Help::class,
			Yume\Fure\HTTP\Server\CLI\Serve::class
		],
		
		/*
		 * Server CLI.
		 *
		 */
		"server" => [
			"host" => env( "SERVER_HOST", "127.0.0.1" ),
			"port" => env( "SERVER_PORT", 8004 )
		],
		
		/*
		 * Services Provider Classes.
		 *
		 * It is hoped not to delete the default
		 * Service Provider that has been set.
		 *
		 * You can add your own custom Service Provider
		 * class or from a library you have added.
		 *
		 */
		"services" => [
			Yume\App\Providers\AppServiceProvider::class,
			Yume\App\Providers\ConfigServiceProvider::class
		],
		
		/*
		 * Application version.
		 *
		 * @default None
		 */
		"version" => env( "APP_VERSION", "Unititialized" ),
		
	])
);

?>