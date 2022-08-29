<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;
use Yume\Fure\View;

/*
 * SyntaxAssigment
 *
 * @extends Yume\Fure\View\Template\TemplateSyntax
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxAssigment extends View\Template\TemplateSyntax
{
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntax
     *
     */
    protected ? String $regexp = "/(?:(?<syntax>\@def[\s\t]+(?<value>[^\n]*)))/i";
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntax
     *
     */
    protected function handler( AoE\Data $match, Callable $self ): String
    {
        if( $this->valueIsEmpty( $match->value ) )
        {
            // Invalid syntax definition.
            return( "" );
        } else {
            
            // Return syntax scheme.
            return( f( "<?php { value }; ?>", $match ) );
        }
    }
}

?>