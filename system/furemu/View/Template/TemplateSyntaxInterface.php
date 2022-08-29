<?php

namespace Yume\Fure\View\Template;

use Stringable;

/*
 * TemplateSyntaxInterface
 *
 * @extends Stringable
 *
 * @package Yume\Fure\View\Template
 */
interface TemplateSyntaxInterface extends Stringable
{
    
    /*
     * Construct method of class TemplateSyntax.
     *
     * @access Public Instance
     *
     * @params String $view
     * @params String $content
     *
     * @return Void
     */
    public function __construct( String $view, String $content );
    
    /*
     * Return content file view.
     *
     * @access Public
     *
     * @return String
     */
    public function getContent(): String;
    
    /*
     * Return regular syntax expression.
     *
     * @access Public
     *
     * @return String
     */
    public function getRegExp(): String;
    
    /*
     * Return view filename.
     *
     * @access Public
     *
     * @return String
     */
    public function getView(): String;
    
    /*
     * Parse view.
     *
     * @access Public
     *
     * @params Callable $self
     *
     * @return String
     */
    public function parse( Callable $self ): String;
    
}

?>