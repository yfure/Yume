<?php

return([
	"security" => [
		"connection" => [
			"allow.tor" => False
		],
		"exception" => [
			"unauthorize" => Yume\Fure\Error\HttpAuthorizationError::class
		],
		"filter" => [
		],
		"match" => [
		]
	]
]);

?>