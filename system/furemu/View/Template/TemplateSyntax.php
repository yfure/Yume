<?php

namespace Yume\Fure\View\Template;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;

/*
 * TemplateSyntax
 *
 * @package Yume\Fure\View\Template
 */
abstract class TemplateSyntax implements TemplateSyntaxInterface
{
    
    /*
     * Regular expression for syntax.
     *
     * @access Protected
     *
     * @values String
     */
    protected ? String $regexp = Null;
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntaxInterface
     *
     */
    public function __construct( protected String $view, protected String $content )
    {
        // If the syntax does not have a regular expression.
        if( $this->regexp === Null )
        {
            throw new TemplateError( $this::class, TemplateError::REGEXP_ERROR );
        }
    }
    
    /*
     * Parse class into string.
     *
     * @access Public
     *
     * @return String
     */
    public function __toString(): String
    {
        return( $this->getRegExp() );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntaxInterface
     *
     */
    public function getContent(): String
    {
        return( $this->content );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntaxInterface
     *
     */
    public function getRegExp(): String
    {
        return( $this->regexp );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntaxInterface
     *
     */
    public function getView(): String
    {
        return( $this->view );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateSyntaxInterface
     *
     */
    public function parse( Callable $self ): String
    {
        return( RegExp\RegExp::replace( $this->regexp, $this->content, fn( Array $match ) => $this->handler( new AoE\Data( RegExp\RegExp::clear( $match, True ) ), $self ) ) );
    }
    
    /*
     * Check if the value is empty.
     *
     * @access Public
     *
     * @params Bool|Null|String $params
     *
     * @return Bool
     */
    public function valueIsEmpty( Bool | Null | String $params ): Bool
    {
        if( $params !== False &&
            $params !== Null &&
            $params !== "" )
        {
            return( RegExp\RegExp::test( "/^[\r\t\n\s]+$/", $params ) );
        }
        return( True );
    }
    
    /*
     * Functions that handle match results.
     *
     * @access Protected
     *
     * @params Yume\Fure\AoE\Data $match
     * @params Callable $self
     *
     * @return String
     */
    abstract protected function handler( AoE\Data $match, Callable $self ): String;
    
}

?>