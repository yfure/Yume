<?php

return([
	
	/*
	 * Common application configuration.
	 *
	 * @values String
	 */
	"name" => env( "APP_NAME", "The Yume Framework" ),
	"version" => env( "APP_VERSION", "4.4.0" ),
	
	/*
	 * Register commands.
	 *
	 * @values Array<String>
	 */
	"commands" => [
		Yume\Fure\CLI\Command\Helper\Help::class => [
			"command" => "\x63\x6f\x6d\x6d\x61\x6e\x64\x73\x3a\x7b\x7d",
			"formats" => [
				"command.about" =>              "\x20\x20\x20\x20\x7b\x7d",
				"command.group-name" =>         "\x20\x20\e\x5b\x31\x3b\x33\x38\x3b\x35\x3b\x31\x31\x32\x6d\x7b\x7d\e\x5b\x30\x6d",
				"command.info" =>               "\x20\x20\x20\x20\e\x5b\x31\x3b\x33\x38\x3b\x35\x3b\x31\x39\x30\x6d\x7b\x7d\e\x5b\x30\x6d\x0a\x7b\x7d",
				"command.info-name" =>          "\x20\x20\x20\x20\e\x5b\x31\x3b\x33\x38\x3b\x35\x3b\x31\x39\x30\x6d\x7b\x7d\e\x5b\x30\x6d",
				"command.option.name-join" =>   "\x20\x20\x20\x20\x7b\x7d\x20\x7b\x7d",
				"command.option.explain" =>     "\x20\x20\x20\x20\x20\x20\x7b\x7d",
				"command.option.single-info" => "\x20\x20\x20\x20\x20\x20\x20\e\x5b\x31\x3b\x33\x32\x6d\xc2\xb7\e\x5b\x30\x6d\x20\x7b\x7d\x20\x7b\x7d",
				"command.option.multi-info" =>  "\x20\x20\x20\x20\x20\x20\x20\e\x5b\x31\x3b\x33\x32\x6d\xc2\xb7\e\x5b\x30\x6d\x20\x7b\x7d\x20\x5b\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x7b\x7d\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x5d"

			],
			"usage" => "\x7b\x30\x7d\x75\x73\x61\x67\x65\x3a\x20\x73\x61\x73\x61\x79\x61\x6b\x69\x20\e\x5b\x31\x3b\x33\x38\x3b\x35\x3b\x31\x31\x32\x6d\x63\x6f\x6d\x6d\x61\x6e\x64\e\x5b\x30\x6d\x20\x2d\x2d\e\x5b\x31\x3b\x33\x38\x3b\x35\x3b\x31\x39\x30\x6d\x6f\x70\x74\x69\x6f\x6e\e\x5b\x30\x6d\x20\e\x5b\x31\x3b\x33\x32\x6d\x61\x72\x67\x75\x6d\x65\x6e\x74\x73\e\x5b\x30\x6d",
			"welcome" => [
				"\x54\x68\x65\x20\x59\x75\x6d\x65\x20\x46\x72\x61\x6d\x65\x77\x6f\x72\x6b",
				"\x54\x68\x65\x20\x53\x61\x73\x61\x79\x61\x6b\x69\x20\x43\x6f\x6d\x6d\x61\x6e\x64\x20\x4c\x69\x6e\x65\x20\x49\x6e\x74\x65\x72\x66\x61\x63\x65\x20\x54\x6f\x6f\x6c"
			]
		],
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
