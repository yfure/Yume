<?php

return([
	
	/*
	 * Default language translation.
	 *
	 * @values inherit:Yume\Fure\Locale\Locale::DEFAULT_LANGUAGE
	 */
	"language" => env( "LOCALE_LANGUAGE", Yume\Fure\Locale\Locale::DEFAULT_LANGUAGE ),
	
	/*
	 * Default timezone application.
	 *
	 * @values inherit:Yume\Fure\Locale\Locale::DEFAULT_TIMEZONE
	 */
	"timezone" => env( "LOCALE_TIMEZONE", Yume\Fure\Locale\Locale::DEFAULT_TIMEZONE )
]);

?>