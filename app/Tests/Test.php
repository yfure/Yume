<?php

try {
	
	class Fun
	{
		public function __invoke( $i, $x, $y, $z )
		{
			// ...
		}
		public function fun( Int $i, Int|Bool $x, Array|Null|Yume\Fure\Support\Data\DataInterface $y, Iterator & Yume\Fure\Support\Data\DataInterface $z )
		{
			// ...
		}
	}
	
	function fun( Int $i, Int|Bool $x, Array|Null|Yume\Fure\Support\Data\DataInterface $y, Iterator & Yume\Fure\Support\Data\DataInterface $z )
	{
		// ...
	}
	
	// Instance class.
	$fun = new Fun;
	
	// Reference.
	$ref = [];
	
	// Parameters.
	$i = new ReflectionParameter( param: "i", function: [ $fun, "fun" ]);
	
	// Testing!
	$p = Yume\Fure\Support\Reflect\ReflectParameter::builder(
		reflect: $ref,
		arguments: [
			0
		],
		parameter: [
			"array.define" => [
				"function" => [
					"fun"
				],
				"reflect" => $i,
				"param" => "x"
			],
			"array.string" => [
				"function" => [
					"Fun",
					"fun"
				],
				"reflect" => $i,
				"param" => "x"
			],
			"array.object.invoke" => [
				"function" => [
					$fun
				],
				"reflect" => $i,
				"param" => "i"
			],
			"array.object.method" => [
				"function" => [
					$fun,
					"fun"
				],
				"reflect" => $i,
				"param" => "y"
			],
			"object" => [
				"function" => $fun,
				"reflect" => $i,
				"param" => "z"
			],
			"string" => [
				"function" => "fun",
				"reflect" => $i,
				"param" => "z"
			],
			"string.static" => [
				"function" => "Fun::fun",
				"reflect" => $i,
				"param" => "z"
			]
		]
	);
	
	var_dump([ $p ]);
}
catch( Throwable $e )
{
	echo path( remove: True, path: f( "\x1b[1;32m{}\x1b[1;33m: \x1b[0;37m{} in file \x1b[1;36m{} \x1b[0;37mon line \x1b[1;31m{}\n\x1b[1;30m{}\n", ...[
		$e::class,
		$e->getMessage(),
		$e->getFile(),
		$e->getLine(),
		$e->getTrace()
	]));
}

?>