<?php

/*
 * ...
 *
 * @return Yume\Fure\Support\Config\Config
 */
return(
	new Yume\Fure\Support\Config\Config( "Cache", [
		
		/*
		 * For cache we also have several adapters
		 * that can be configured accordingly.
		 *
		 * You can also use third-party adapters,
		 * just add the class name and configuration.
		 *
		 */
		"adapter" => [
			Yume\Fure\Cache\Adapter\FileSystemAdapter::class => [
				"path" => Yume\Fure\Support\Path\PathName::ASSET_CACHE->value,
				"extension" => "cache",
				"permission" => 0777
			],
			Yume\Fure\Cache\Adapter\MemcachedAdapter::class => [
			]
		],
		
		/*
		 * Default cache adapter class.
		 *
		 */
		"default" => Yume\Fure\Cache\Adapter\FileSystemAdapter::class,
		
		"time" => [
			
			/*
			 * Default Time to Live Cache.
			 *
			 * @default 60
			 */
			"live" => 60
		]
		
	])
);

?>