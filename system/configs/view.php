<?php

use Yume\Fure\Config;
use Yume\Fure\View;
use Yume\Fure\View\Template;
use Yume\Fure\View\Template\Parser;
use Yume\Fure\View\Template\Process;

/*
 * Views Configuration.
 *
 */
return(
	new Config\Config( "View", [
		
		/*
		 * View cache configuration.
		 *
		 */
		"cache" => [
			"name" => "yvic",
			"pool" => "views"
		],
		
		/*
		 * Views extension name.
		 *
		 * @default yvi (Yume View)
		 */
		"extension" => "yvi",
		
		/*
		 * Views pathname.
		 *
		 * @default /assets/views
		 */
		"path" => Yume\Fure\Support\Path\PathName::ASSET_VIEW->value,
		
		/*
		 * Views template configuration.
		 *
		 */
		"template" => [
			
			/*
			 * Template comment configuration.
			 *
			 */
			"comment" => [
				"remove" => False,
				"display" => True
			],
			
			/*
			 * Template indentation configuration.
			 *
			 */
			"indent" => [
				"length" => 4,
				"value" => "\x20"
			],
			
			"parser" => []
			
		]
		
	])
);

?>