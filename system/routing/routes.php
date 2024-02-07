<?php

use Yume\App\Http\Controllers;

use Yume\Fure\Http\Request;
use Yume\Fure\Http\Router;

/*
 * Welcome
 *
 * This is an example how you can define route in Yume.
 *
 * @path /
 */
Router\Route::get(
	
	// Route pathname.
	path: "/",
	
	// Route handler.
	// You can use controller method or closure.
	handler: Controllers\Welcome::class,
	
	/*
	 * Route children.
	 *
	 * @params Yume\Fure\Http\Request\RequestInterface $request
	 *
	 * @return Void
	 */
	children: function( Request\RequestInterface $request ): Void {

		/*
		 * To define parameters in the handler you have to give a name to your
		 * regular expression group, each group name will be changed to camelCase
		 * style make sure you adjust that also in your route handler function.
		 * 
		 * @syntax :id([1-9][0-9]{9}) => id
		 * @syntax :userId([1-9][0-9]{9}) => userId
		 * @syntax :user_id([1-9][0-9]{9}) => userId
		 * @syntax (?<username>[a-zA-Z_](?:[a-zA-Z0-9_\.]*[a-zA-Z0-9_]{1})?) => username
		 * 
		 */
		$route = Router\Route::post( "(?:(?<path>[a-zA-Z][a-zA-Z0-9]*))", function( String $path ): Void {
			echo f( "Hello Welcome to <b>{}</b>", $path );
		});
	}
);

?>