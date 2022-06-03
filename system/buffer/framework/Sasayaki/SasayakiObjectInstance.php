<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage\IO;
use Yume\Kama\Obi\Reflection;

class SasayakiObjectInstance extends SasayakiProvider implements SasayakiInterface
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
    protected $pattern = "/\@\\\([a-z\_][a-z0-9\_\\\]+[a-z0-9\_])\((.*?)\)\;/si";
    
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
        $this->content = HTTP\Filter\RegExp::replace( $this->pattern, $content, function( $m ) use( $data ) {
            
            $result = [
                
                // Object Name.
                'name' => $m[1],
                
                // Object Params.
                'params' => [],
                
                // Object Result.
                'return' => Null
            ];
            
            // Check if Instance have paramater.
            if( $m[2] !== "" ) {
                
                // Removing spaces.
                $m[2] = HTTP\Filter\RegExp::replace( "/\s/", $m[2], "" );
                
                // Construction Instance with parameter.
                $result['return'] = Reflection\ReflectionInstance::construct( $m[1], SasayakiParameter::params( $m[2], $result, $data ) );
            } else {
                
                // Construction Instance without parameter.
                $result['return'] = Reflection\ReflectionInstance::construct( $m[1] );
            }
            return( AoE\Stringable::parse( ( $this->result[] = $result )['return'] ) );
        });
    }
    
}

?>