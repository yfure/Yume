<?php

use Yume\Fure\Logger;
use Yume\Fure\Logger\Handler;
use Yume\Fure\Support\Config;
use Yume\Fure\Util\File\Path;

/*
 * ...
 *
 * @return Yume\Fure\Support\Config\Config
 */
return(
	new Yume\Fure\Support\Config\Config( "Logger", [
		"date" => [
			"format" => "d-m-Y H:i:s"
		],
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
				 */
				"handles" => [
					Logger\LoggerLevel::ALERT,
					Logger\LoggerLevel::CRITICAL,
					Logger\LoggerLevel::DEBUG,
					Logger\LoggerLevel::EMERGENCY,
					Logger\LoggerLevel::ERROR,
					Logger\LoggerLevel::INFO,
					Logger\LoggerLevel::NOTICE,
					Logger\LoggerLevel::WARNING
				],
				
				/*
				 * Path stored logs.
				 *
				 */
				"path" => Path\Paths::ASSET_LOGGING->value,
				
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
		"threshold" => [ 4 ]
	])
);

?>