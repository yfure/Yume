<?php

use Yume\Fure\Config;

return(
	new Config\Config( "Error", [

		/*
		 * Default error handler.
		 * This is only use when the environment
		 * variable ERROR_HANDLER does not set on .env file.
		 * 
		 * @default Yume\Fure\Error\Handler\ErrorHandler
		 */
		"error" => "Yume\\Fure\\Error\\Handler\\ErrorHandler::handler",
		
		/*
		 * Default exception handler.
		 * This is only use when the environment
		 * variable EXCEPTION_HANDLER does not set on .env file.
		 * 
		 * @default Yume\Fure\Error\Handler\ExceptionHandler
		 */
		"exception" => "Yume\\Fure\\Error\\Handler\\ExceptionHandler::handler",
		
		/*
		 * Exception view name.
		 *
		 * @default errors/exception
		 */
		"exception.view" => "errors/exception"
		
	])
);

?>