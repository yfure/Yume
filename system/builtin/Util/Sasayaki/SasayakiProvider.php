<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Storage\IO;
use Yume\Kama\Obi\Reflection;

class SasayakiProvider implements SasayakiInterface
{
    
    /*
     * Results pattern.
     *
     * @access Protected
     *
     * @values Array
     */
    protected $result = [
        "Document" => [],
        "ObjectInstance" => [],
        "ObjectFunction" => [],
        "Function" => [],
        "ObjectConstant" => [],
        "ObjectVariable" => [],
        "Constant" => [],
        "Variable" => [],
        "Object" => [],
        "Component" => [],
        "Resource" => []
    ];
    
    /*
     * Content replaced.
     *
     * @access Protected
     *
     * @values String
     */
    protected $content;
    
    /*
     * Regular Expression pattern.
     *
     * @access Protected
     *
     * @values String
     */
    protected $pattern = "//";
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function __construct( String | IO\Fairu $content, Array | AoE\Hairetsu $data, Array | AoE\Hairetsu & $refer = [] )
    {
        /*
         * Parse to string if object
         *
         */
        if( is_object( $content ) )
        {
            $content = $content->reader();
        }
        
        if( $content !== "" )
        {
            /*
             * Search and Replace.
             *
             */
            $this->search( $content, $data );
        }
    }
    
    /*
     * Allows a class to decide how it will
     * React when it is treated like a string.
     * 
     * @access Public
     * 
     * @return String
     */
    public function __toString(): String
    {
        return( "{$this->content}" );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function search( String $content, Array | AoE\Hairetsu $data ): Void
    {
        /*
         * Fill content property
         */
        $this->content = $content;
        
        foreach( $this->result As $key => $val )
        {
            $this->content = ( new ( "Yume\Kama\Obi\Sasayaki\Sasayaki{$key}" )( $this->content, $data, $this->result[$key] ) )->getContent();
        }
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function getResult(): Array
    {
        return( $this->result );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function getContent(): String
    {
        return( "$this->content" );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function getPattern(): String
    {
        return( $this->pattern );
    }
    
}

?>