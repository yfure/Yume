<?php

namespace Yume\Fure\View\Syntax;

use Yume\Fure\AoE;
use Yume\Fure\View;

use Closure;

/*
 * SyntaxOutput
 *
 * Handle output syntax e.g echo, print
 *
 * @extends Yume\Fure\View\Tokenizer\Tokenizer
 *
 * @package Yume\Fure\View\Syntax
 */
class SyntaxOutput extends View\Tokenizer\Tokenizer
{
    
    /*
     * @inherit Yume\Fure\View\TokenizerInterface
     *
     */
    public function __construct( protected Closure $parser, protected String $content, protected String $view )
    {
        /*
         * @inherit Yume\Fure\View\Tokenizer\Tokenizer
         *
         */
        $this->regexp = "/\@(?<unescape>\:*)(?<token>(echo|print)\b)[\s]+(?<value>[^\;]*)\;/i";
    }
    
    /*
     * @inherit Yume\Fure\View\Tokenizer
     *
     */
    final protected function handler( AoE\Data $match ): ? String
    {
        // If unescape symbol not found.
        if( $match->unescape === False )
        {
            $match->value = f( "htmlspecialchars( { value } )", $match );
        }
        return( f( "<?php { token } { value }; ?>", $match ) );
    }
    
}

?>