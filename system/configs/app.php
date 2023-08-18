<?php

return([
	
	/*
	 * Common application configuration.
	 *
	 * @values String
	 */
	"name" => env( "APP_NAME", "Yume" ),
	"version" => env( "APP_VERSION", "4.4.0" ),
	
	/*
	 * Register commands.
	 *
	 * @values Array<String>
	 */
	"commands" => [
		Yume\Fure\CLI\Command\Helper\Help::class,
		Yume\Fure\CLI\Command\Helper\Helper::class
	],
	
	/*
	 * Server configuration.
	 *
	 * @values Array<String,String>
	 */
	"server" => [
		"host" => env( "SERVER_HOST", "127.0.0.1" ),
		"port" => env( "SERVER_PORT", 8004 )
	],
	
	/*
	 * Services providers.
	 *
	 * @values Array
	 */
	"services" => [
		Yume\Fure\Logger\LoggerServiceProvider::class
	]
	
]);

?>