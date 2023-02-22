<?php

namespace Yume\App\Providers;

use Yume\Fure\App;
use Yume\Fure\Support\Services;

/*
 * ConfigServiceProvider
 *
 * @package Yume\App\Providers
 *
 * @extends Yume\Fure\Support\Services\ServiceProvider
 */
class ConfigServiceProvider extends Services\ServiceProvider
{
	
	/*
	 * @inherit Yume\Fure\Support\Services\ServiceProviderInterface
	 *
	 */
	public function register(): Void
	{
		$this->bind( "config", fn() => fn( String $name, Bool $import = False ) => App\App::self()->config( $name, $import ), False );
	}
	
}

?>