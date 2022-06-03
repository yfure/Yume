<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage\IO;
use Yume\Kama\Obi\Reflection;

class SasayakiObjectConstant extends SasayakiProvider implements SasayakiInterface
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
    protected $pattern = "/\@\\\([a-zA-Z\_][a-zA-Z0-9\_\\\]+[a-zA-Z-0-9\_])\:\:([A-Z\_][A-Z0-9\_]+)\;/";
    
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
                
                // Const Name.
                'name' => $m[2],
                
                // Object Name.
                'object' => $m[1],
                
                // Const Value.
                'values' => Reflection\ReflectionInstance::reflect( $m[1] )->getConstant( $m[2] )
            ];
            return( AoE\Stringable::parse( $result['values'] ) );
        });
    }
    
}

?>