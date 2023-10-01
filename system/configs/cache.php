<?php

return([

	/*
	 * For cache we also have several adapters that can be configured accordingly.
	 * 
	 * You can also use third-party adapters,
	 * just add the class name and configuration.
	 * 
	 */
	"adapter" => [
		Yume\Fure\Cache\Pool\FileSystemPool::class => [
			"path" => Yume\Fure\IO\Path\Paths::StorageCache->value,
			"extension" => "cache",
			"permission" => 0777
		],
		Yume\Fure\Cache\Pool\MemcachedAdapter::class => [
		]
	],
	"default" => Yume\Fure\Cache\Pool\FileSystemPool::class,
	"time" => [
		"live" => 60
	]
]);

?>
