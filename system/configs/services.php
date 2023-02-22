<?php

return(
	new Yume\Fure\Config\Config( "Services", [
		
		/*
		 * Application Services Provider Classes.
		 *
		 * It is hoped not to delete the default
		 * Service Provider that has been set.
		 *
		 * You can add your own custom Service Provider
		 * class or from a library you have added.
		 *
		 */
		Yume\App\Providers\AppServiceProvider::class,
		Yume\App\Providers\ConfigServiceProvider::class
	])
);

?>