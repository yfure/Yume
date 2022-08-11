<?php

namespace Yume\Fure\View\Tokenizer;

use Closure;

/*
 * TokenizerInterface
 *
 * @package Yume\Fure\View\Tokenizer
 */
interface TokenizerInterface
{
    
    /*
     * Construct method of class Tokenizer.
     *
     * @access Public Instance
     *
     * @params Closure $parser
     * @params String $content
     *
     * @return Void
     */
    public function __construct( Closure $parser, String $content, String $view );
    
    /*
     * Render template syntax.
     *
     * @access Public
     *
     * @return Static
     */
    public function render(): String;
    
}

?>