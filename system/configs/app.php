<?php

/*
 * Application configuration.
 *
 * @return Yume\Fure\Config\Config
 */
return(
	new Yume\Fure\Config\Config( "App", [
		
		"name" => env( "APP_NAME", "Yume" )
		
	])
);

?>