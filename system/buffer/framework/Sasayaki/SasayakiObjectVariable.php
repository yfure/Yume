<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage\IO;
use Yume\Kama\Obi\Reflection;

class SasayakiObjectVariable extends SasayakiProvider implements SasayakiInterface
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
    protected $pattern = "/\@\\\([a-zA-Z\_][a-zA-Z0-9\_\\\]+[a-zA-Z-0-9\_])\:\:([a-z\_][a-z0-9\_]+)\;/i";
    
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
        $this->content = HTTP\Filter\RegExp::replace( $this->pattern, $content, function( $m ) {
            $this->result[] = $result = [
                
                // Var Name.
                'name' => $m[2],
                
                // Object Name.
                'object' => $m[1],
                
                // Property Value.
                'values' => Reflection\ReflectionProperty::getValue( $m[2], Reflection\ReflectionInstance::construct( $m[1] ) )
            ];
            return( AoE\Stringable::parse( $result['values'] ) );
        });
    }
    
}

?>