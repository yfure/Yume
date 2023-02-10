<?yvi

@use Yume\Fure\Util;

#!DOCTYPE/html
@html lang="en" data-theme="dark":
	@head:
		
		<++ Character Set ++>
		@meta charset="UTF-8";
		
		<++ Author Name ++>
		@meta name="author" content[env( "APP_AUTHOR" )];
		
		<++ Theme Color ++>
		@meta name="theme-color" content="";
		
		<++ Site Title ++>
		@title: hxAri
		
		<++ Styling ++>
		@link rel="stylesheet" href[path( "/assets/styles/yume.css" )];
		
		<++ Builtin Style ++>
		@style type="text/css":
			* {
				margin: 0;
				padding: 0;
				scroll-behavior: smooth;
			}
		
	@body:
		
		<-- Application Mount -->
		@div class="root" id[ $root ?? "root" ]:
			@if $name !== 0:
				@try:
					@isset $x:
						@throw new TypeError;
					@empty $x:
						@throw new ErrorException;
				@catch Error $e:
					@while True:
						pass
				@catch TypeError $e:
					@do:
						pass
					@while False;
				@finally:
					pass
			@elif xx:
				@if $x:
					@for $i = 0\; $i < 10\; $i++:
						@puts "{}. I'm sorry", $i;
						@if $i >= 9:
							@break;
					@foreach $x As $y => $z:
						@puts "[{}] {}", $y, $z;
						@if $y <= 10:
							@continue;
			@else:
				@puts "", format\: "";
		
		<-- Builtin Script -->
		@script type="text/javascript":
			var x = () => 0;

?>