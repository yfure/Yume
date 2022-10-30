<?php

return(
	new Yume\Fure\App\Config\Config( "App", [
		
		/** APPLICATION INFORMATION */
		"app.name" => env( "APP_NAME", "Yume" ),
		"app.author" => env( "APP_AUTHOR", "Ari Setiawan (hxAri)" ),
		"app.domain" => env( "APP_DOMAIN", "https://example.com" ),
		"app.issues" => env( "APP_ISSUES", "https://github.com/yfure/Yume/issues" ),
		"app.source" => env( "APP_SOURCE", "https://github.com/yfure/Yume" ),
		
		/** APPLICATION LICENSE */
		"app.licence" => "MIT",
		
		/** APPLICATION VERSION */
		"app.version" => "16.02.45",
		
		/** APPLICATION PROVIDERS */
		"providers" => [
			
		]
		
	])
);

?>