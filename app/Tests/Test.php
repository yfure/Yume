<?php

try {
	
	class Fun
	{
		public function __invoke( $i, $x, $y, $z )
		{
			// ...
		}
		public function fun( Int $i, Int|Bool $x, Array|Yume\Fure\Support\Data\DataInterface $y, Iterator & Yume\Fure\Support\Data\DataInterface $z )
		{
			// ...
		}
	}
	
	function fun( Int $i, Int|Bool $x, Array|Yume\Fure\Support\Data\DataInterface $y, Iterator & Yume\Fure\Support\Data\DataInterface $z )
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
	$r = Yume\Fure\Support\Reflect\ReflectParameter::builder(
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
	
	var_dump([ $r ]);
}
catch( Throwable $e )
{
	echo path( remove: True, path: f( "<pre>{}: {}\nin file {}\non line {}\n{}", ...[
		$e::class,
		$e->getMessage(),
		$e->getFile(),
		$e->getLine(),
		$e->getTrace()
	]));
}

?>