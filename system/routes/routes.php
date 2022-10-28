<?php

use Yume\App\HTTP\Controllers;

use Yume\Fure\HTTP;

HTTP\Route\Route::get(
	"/",
	Controllers\Welcome::class,
	function()
	{
		HTTP\Route\Route::get(
			"*", 
			function()
			{
				// ...
			}
		);
	}
);

?>