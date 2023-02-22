<?php

/*
 * Configuration for Error and Exception.
 *
 */
return(
	new Yume\Fure\Config\Config( "Error", [
		
		"handler" => [
			
			/*
			 * Default error handler.
			 * This is only use when the environment
			 * variable TRIGGER_HANDLER does not set on .env file.
			 *
			 * Please be aware, that any error that is emitted will
			 * be thrown error will be thrown as Throwable Object,
			 * for Object that is thrown usually is TriggerError this
			 * corresponds to the name of the error being emitted or
			 * triggered and this only applies to Yume built-in methods
			 * or functions you can override it anytime, and make it a
			 * View file so errors can be easily understood, by default
			 * Yume only generates it for exceptions.
			 * 
			 * @default Yume\\Fure\\Error\\Erahandora\\Erahandora::trigger
			 */
			"trigger" => env( "TRIGGER_HANDLER", "Yume\\Fure\\Error\\Erahandora\\Erahandora::trigger" ),
			
			/*
			 * Default exception handler.
			 * This is only use when the environment
			 * variable EXCEPTION_HANDLER does not set on .env file.
			 * 
			 * @default Yume\\Fure\\Error\\Erahandora\\Erahandora::exception
			 */
			"exception" => env( "EXCEPTION_HANDLER", "Yume\\Fure\\Error\\Erahandora\\Erahandora::exception" ),
		],
		
		/*
		 * Exception log permission.
		 *
		 * Before you enable it please note that an exception is
		 * not an error that should be logged in the log file, but
		 * here Yume provides freedom for that, but it is highly
		 * recommended not to enable it when
		 * in a Production Environment.
		 *
		 * @default False
		 */
		"exception.log" => False,
		
		/*
		 * Exception view name.
		 *
		 * Be careful when you want to change the contents of a View,
		 * it is highly recommended to make a copy.
		 *
		 * @default errors/exception
		 */
		"exception.view" => "errors/exception"
		
	])
);

?>