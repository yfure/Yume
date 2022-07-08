<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\HTTP;

final class Runtime
{
	
	/*
	 * Application class instance.
	 *
	 * @access Public Static
	 *
	 * @values Yume\Kama\Obi\AoE\App
	 */
	public static ? App $app = Null;
	
	/*
	 * Router class instance.
	 *
	 * @access Public Protected
	 *
	 * @values Yume\Kama\Obi\HTTP\Routing\Router
	 */
	protected static HTTP\Routing\Router $router;
	
	public static function start(): Void
	{
		
		// Check if the application already exists.
		if( self::$app Instanceof App )
		{
			throw new Trouble\RuntimeError( "Application initialization found, application cannot be duplicated." );
		}
		
		// Initialize app.
		self::$app = new App;
		
		// Run application services.
		self::$app->service();
		
		echo "<pre>\n";
		
		// {}
		$obj = new Class
		{
			
			public Readonly Array $tree;
			public String $readed = "";
			
			public function __construct()
			{
				$this->loop( $this->tree = [ "system" => tree( "/system" ) ] );
			}
			
			public function loop( Array $array, String $in = "" )
			{
				foreach( $array As $i => $v )
				{
					if( is_array( $v ) )
					{
						$this->loop( $v, f( "{}/{}", $in, $i ) );
					} else {
						
						// Create file name.
						$fname = f( "{}/{}", $in, $v );
						
						// Get file contents.
						$fdata = \Yume\Kama\Obi\IO\File::read( $fname );
						
						$this->bund( $fname, $fdata );
						$this->repl( $fname, $fdata );
					}
				}
			}
			
			public function bund( String $fname, String $fdata )
			{
				
				$fstrip = "";
				$length = strlen( $fname = \Yume\Kama\Obi\RegExp\RegExp::replace( "/(?:(\/|\.php\b))/", \Yume\Kama\Obi\RegExp\RegExp::replace( "/(?:(^\/))/", $fname, "" ), fn( $m ) => $m[0] === "/" ? "." : "" ) );
				
				for( $i = 0; $i < $length; $i++ )
				{
					$fstrip .= "-";
				}
				
				$this->readed .= f( "\n//\x20{}\n//\x20{}\n//\x20{}{}", $fstrip, $fname, $fstrip, \Yume\Kama\Obi\RegExp\RegExp::replace( "/(?:(^\<\?php|^\?\>|\t))/m", $fdata, fn( $m ) => $m[0] === "\t" ? "\x20\x20\x20\x20" : "" ) );
			}
			
			public function repl( String $fname, String $fdata )
			{
				$regexp = f( "/(?:(?<RegExp>({})))/im", implode( "|", [
					implode( "", [
						"(",
							"(?<WithReflector>\bKurasu\b)",
						")"
					]),
				]));
				
				$replace = \Yume\Kama\Obi\RegExp\RegExp::replace( $regexp, $fdata, function( $m )
				{
					return( "ReflectClass" );
				});
				
				if( $replace !== $fdata )
				{
					echo $fname . "\n";
				}
				
			}
			
		};
		
		\Yume\Kama\Obi\IO\File::write( "mixed.php", f( "<?php\n{}?>", $obj->readed ) );
		
		exit;
		
		if( CLI )
		{
			/*
			 * Handle command line arguments.
			 *
			 * It will serve just as it would build controllers,
			 * Components, models, and so on. If no command is sent,
			 * The program will be terminated.
			 */
			
		} else {
			
			// ...
			self::$router = new HTTP\Routing\Router;
			
			// ...
			self::$router->create();
			
			// ...
			self::$router->dispatch();
			
		}
	}
	/*
	function class_uses_deep($class, $autoload = true)
	{
		$traits = [];
	
		// Get traits of all parent classes
		do {
			$traits = array_merge(class_uses($class, $autoload), $traits);
		} while ($class = get_parent_class($class));
	
		// Get traits of all parent traits
		$traitsToSearch = $traits;
		while (!empty($traitsToSearch)) {
			$newTraits = class_uses(array_pop($traitsToSearch), $autoload);
			$traits = array_merge($newTraits, $traits);
			$traitsToSearch = array_merge($newTraits, $traitsToSearch);
		};
	
		foreach ($traits as $trait => $same) {
			$traits = array_merge(class_uses($trait, $autoload), $traits);
		}
	
		return array_unique($traits);
	}
	*/
}

?>