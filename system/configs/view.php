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
		 * Views extension name.
		 *
		 * @default yvi (Yume View)
		 * @default yvic (Yume View Cache)
		 */
		"extension" => "yvi",
		"extension.cache" => "yvic",
		
		/*
		 * Minimum compiled cache.
		 *
		 * By default we apply it to 60 seconds, which means if
		 * the view file was modified less than 60 seconds ago
		 * then the view template will be recompiled, except
		 * if the cached view file is missing then recompile.
		 *
		 * @default 60 (Seconds)
		 */
		"modify" => 60,
		
		/*
		 * Views pathname.
		 *
		 * @default /assets/views
		 * @default /assets/caches/views
		 */
		"path" => Yume\Fure\Support\Path\PathName::ASSET_VIEW->value,
		"path.cache" => Yume\Fure\Support\Path\PathName::ASSET_CACHE_VIEW->value,
		
		/*
		 * Template Engine configurations.
		 *
		 * This is Yume's built-in template engine which we named Nemuri.
		 *
		 * Here unlike most other PHP Template Engines,
		 * Yume's built-in Template Engine (Nemuri) uses
		 * Indented syntax similar to the code syntax in
		 * Python Programming in order to make the code easy
		 * to read and maintain but apart from all that it can
		 * also use closing syntax as well.
		 *
		 */
		"template" => [
			
			/*
			 * Template comment configuration.
			 *
			 */
			"comment" => [
				
				/*
				 * Erase every computer that starts with a hash symbol.
				 * If you set this to False then the rules will
				 * follow the HTML comment settings.
				 *
				 * @default True
				 */
				"remove" => True,
				
				/*
				 * Enable display HTML comment.
				 *
				 * @default True
				 */
				"display" => True
			],
			
			/*
			 * Configuration for default processing syntax.
			 *
			 */
			"configs" => [
				Yume\Fure\View\Template\TemplateSyntaxComponent::class => [
				],
				Yume\Fure\View\Template\TemplateSyntaxHTML::class => [
				],
				Yume\Fure\View\Template\TemplateSyntaxPHP::class => [
				]
			],
			
			/*
			 * Template indentation configuration.
			 *
			 * To make it easier for engines to catch our syntax of
			 * using spaces for Indents, all tabs will be
			 * converted to spaces.
			 *
			 */
			"indent" => [
				"length" => 4,
				"value" => "\x20"
			],
			
			/*
			 * Custom class for processing captured syntax.
			 *
			 * For processing class default syntax captured
			 * we store it in class property here only
			 * specially for custom processing.
			 *
			 */
			"syntax" => [
				
				/*
				 * This is an example.
				 *
				 * @syntax => @example "Hello World";
				 */
				Yume\App\Views\Templates\Syntax\SyntaxExample::class => [
					"skip" => False
				]
			]
		]
	])
);

?>