<?php

use Yume\Fure\IO\Path;
use Yume\Fure\Logger;

return([
	
	/*
	 * Logger datetime configuration.
	 *
	 * @include format
	 */
	"date" => [
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
		Handler\FileHandler::class => [
			
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
				Logger\LoggerLevel::Alert,
				Logger\LoggerLevel::Critical,
				Logger\LoggerLevel::Debug,
				Logger\LoggerLevel::Emergency,
				Logger\LoggerLevel::Error,
				Logger\LoggerLevel::Info,
				Logger\LoggerLevel::Notice,
				Logger\LoggerLevel::Warning
			],
			
			/*
			 * Path stored logs.
			 *
			 */
			"path" => Path\Paths::StorageLogging->value,
			
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