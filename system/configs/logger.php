<?php

return([
	
	/*
	 * Logger datetime configuration.
	 *
	 * @include format
	 */
	"datetime" => [
		"format" => "\x64\x2c\x20\x44\x20\x4d\x20\x59\x20\x48\x3a\x69\x3a\x73"
	],
	
	/*
	 * Logger handler configuration.
	 *
	 * @values Array<String,Array>
	 */
	"handlers" => [
		
		/*
		 * This is a default log handler from Yume.
		 *
		 * You can also use a third-party handler or
		 * create your own according to your wishes.
		 *
		 */
		Yume\Fure\Logger\Handler\FileHandler::class => [
			
			/*
			 * Default file extension name.
			 *
			 * @default log
			 */
			"extension" => "log",
			
			/*
			 * Allowed levels.
			 *
			 * @values Array<Yume\Fure\Logger\LoggerLevel>
			 */
			"handles" => [
				Yume\Fure\Logger\LoggerLevel::Alert,
				Yume\Fure\Logger\LoggerLevel::Critical,
				Yume\Fure\Logger\LoggerLevel::Debug,
				Yume\Fure\Logger\LoggerLevel::Emergency,
				Yume\Fure\Logger\LoggerLevel::Error,
				Yume\Fure\Logger\LoggerLevel::Info,
				Yume\Fure\Logger\LoggerLevel::Notice,
				Yume\Fure\Logger\LoggerLevel::Warning
			],
			
			/*
			 * Path stored logs.
			 *
			 */
			"path" => env( "LOGGER_PATH", Yume\Fure\IO\Path\Paths::StorageLogging->value ),
			
			/*
			 * Default file permission.
			 * Dont use string value.
			 * Only otcal value!
			 *
			 * @default 0664
			 * @default 0777
			 */
			"permission" => 0664
		]
	],
	
	/*
	 * Logger threshold configuration.
	 *
	 * @values Array<Int>
	 */
	"threshold" => [
		4
	]
]);

?>