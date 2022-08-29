<?php

namespace Yume\Fure\View\Template;

use Yume\Fure\AoE;
use Yume\Fure\RegExp;
use Yume\Fure\View;

/*
 * Template
 *
 * @package Yume\Fure\View\Template
 */
class Template implements TemplateInterface
{
    
    /*
     * Template variables.
     *
     * @access Protected
     *
     * @values Array
     */
    protected Array $vars = [];
    
    /*
     * Template view name.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $view;
    
    /*
     * Construct method of class Template.
     *
     * @access Public Instance
     *
     * @params String $view
     * @params Array $data
     *
     * @return Void
     */
    public function __construct( Array | AoE\Data $data = [] )
    {
        // Assigning variable.
        $this->assign( $data );
        
        // Check if view is not exists.
        if( View\View::exists( $this->view ) === False )
        {
            throw new TemplateError( $view, TemplateError::VIEW_ERROR );
        }
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function assign( Array | AoE\Data $data ): Static
    {
        if( $data Instanceof AoE\Data )
        {
            $data = $data->__toArray();
        }
        $this->vars = [
            ...$this->vars,
            ...$data
        ];
        return( $this );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function getVars(): Array
    {
        return( $this->vars );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function getView(): String
    {
        return( $this->view );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function getViewFile(): String
    {
        return( View\View::reader( $this->view ) );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function getViewParsed(): String
    {
        return( View\View::reader( $this->view, View\View::F_CACHE_PARSED ) );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function hasCached(): Bool
    {
        return( View\View::cached( $this->view ) );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function hasParsed(): Bool
    {
        return( View\View::parsed( $this->view ) );
    }
    
    /*
     * @inherit Yume\Fure\View\Template\TemplateInterface
     *
     */
    public function render(): Void
    {
        // Application compilation time.
        $compile = 0;
        
        // If the view template has not been cached or has not been parsed.
        if( $this->hasCached() === False ||
            $this->hasParsed() === False || 1 )
        {
            // Read original view file.
            $view = $this->getViewFile();
            
            // Delete or turn entire comments into HTML comment tags.
            $view = RegExp\RegExp::replace( "/(?:(?<syntax>(?<indent>[\s\t]*)\#[\s\t]*(\[(?<comment>[^\]]*)\]|(?<comment>[^\n]*))))/msJ", $view, function( Array $match )
            {
                if( View\View::config( "template.syntax.comment.remove" ) === False )
                {
                    return( f( "{ indent }<!-- { comment } -->", $match ) );
                }
            });
            
            // Compile view template files.
            $compiled = TemplateReflector::compile( $this->view, $view );
            
            // Start compilation time.
            $compile = microtime( True );
            
            // Validate the compilation of view template file.
            TemplateReflector::validate( $this->view, $compiled );
            
            // Compare compilation time.
            $compile = executionTimeCompare( $compile, microtime() );
            
            // Rewrite cache for view files.
            View\View::writer( $this->view, $view, View\View::F_CACHE_LOADED );
            View\View::writer( $this->view, $compiled, View\View::F_CACHE_PARSED );
        }
        
        // Import variables into the current
        // symbol table from an array.
        extract([
            
            // ...
            ...$this->vars,
            
            // Application info...
            "_APP_NAME" => env( "APP_NAME" ),
            "_APP_AUTHOR" => env( "APP_AUTHOR" ),
            "_APP_VERSION" => env( "APP_VERSION" ),
            
            // Application compilation time.
            "_APP_COMPILED" => $compile,
            
            // Application execution time.
            "_APP_EXECUTED" => executionTimeCompare( APP_START, microtime() )
        ]);
        
        //echo f( "<pre>{}", htmlspecialchars( $this->getViewParsed() ) );
        include path( View\View::format( $this->view, View\View::F_CACHE_PARSED ) );
    }
    
}

?>