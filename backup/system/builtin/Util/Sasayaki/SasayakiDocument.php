<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage;
use Yume\Kama\Obi\Reflection;

class SasayakiDocument extends SasayakiProvider implements SasayakiInterface
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $result = [];
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $content;
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $pattern = [
        
        // Single line comment.
        "/([\t]+)*\#\!\-([^\n]+)\n/",
        
        // Multiple line comment.
        "/([\t]+)*\#\[\s*(.*?)\s*\]/s"
        
    ];
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function __construct( String | Storage\IO\Fairu $content, Array | AoE\Hairetsu $data, Array | AoE\Hairetsu & $refer = [] )
    {
        
        /*
         * Parse to string if object
         *
         */
        if( is_object( $content ) )
        {
            $content = $content->reader();
        }
        
        /*
         * Search and Replace.
         *
         */
        $this->search( $content, $data );
        
        /*
         * Insert Variable results.
         */
        foreach( $this->result As $var => $value )
        {
            $refer[$var] = $value;
        }
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function search( String $content, Array | AoE\Hairetsu $data ): Void
    {
        $this->content = $content;
        
        foreach( $this->pattern As $pattern )
        {
            $this->content = HTTP\Filter\RegExp::replace( $pattern, $this->content, function( $m ) {
                
                // Remove identifiers.
                $this->result[] = str_replace( $m[1], "$m[1]\t", $comment = HTTP\Filter\RegExp::replace( "/\@|\;/", $m[2], "" ) );
                
            });
        }
    }
    
}

?>