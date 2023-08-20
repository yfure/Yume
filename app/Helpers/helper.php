<?php

function format( String $format, Mixed ...$values ): String
{
	$patterns = [
		"array" => "",
		"callback" => "",
		"curly" => "",
		"function" => "",
		"iterable" => "",
		"method" => ""
	];
	
	$result = preg_replace_callback( pattern: "/(?<matched>(?<!\\\)\{(?<syntax>.*?)(?<!\\\)\})/ms", subject: $format, callback: fn( Array $match ) => formatHandler( $match, $values ) );
	// $result = formatNormalize( $result );

	return( $result );
}

function formatHandler( Array $match, Array &$values ): String
{
	// Statically variable.
	static $i = 0;

	// Extract variables.
	$matched = trim( $match['matched'] );
	$syntax = trim( $match['syntax'] );

	try
	{}
	catch( Yume\Fure\Error\YumeError $e )
	{}
}

function formatNormalize( String $string ): String
{
	return( preg_replace_callback( pattern: "/(?:(?<backslash>\\\{1,})(?<curly>\{|\}))/ms", subject: $string, callback: fn( Array $match ) => sprintf( "%s%s", $match['backslash'] === "\x5c" ? "" : str_repeat( "\x5c", strlen( $match['backslash'] ) -1 ), $match['curly'] ) ) );
}

function formtValue(): Mixed
{}

?>