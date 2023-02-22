<?php

namespace Yume\App\Views\Templates\Syntax;

use Yume\Fure\Support\Data;
use Yume\Fure\View\Template;

/*
 * SyntaxExample
 *
 * @package Yume\App\Views\Templates\Syntax
 *
 * @extends Yume\Fure\View\Template\TemplateSyntax
 */
final class SyntaxExample extends Template\TemplateSyntax
{
	
	/*
	 * @inherit Yume\Fure\View\Template\TemplateSyntax
	 *
	 */
	protected Array | String $token = "example";
	
	/*
	 * @inherit Yume\Fure\View\Template\TemplateSyntaxInterface
	 *
	 */
	public function process( Data\DataInterface $syntax ): Array | String
	{
		return( f( "{syntax.indent.value}<? echo \"This is an example syntax process\"; ?>", syntax: $syntax ) );
	}
	
}

?>