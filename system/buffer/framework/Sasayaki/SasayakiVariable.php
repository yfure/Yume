<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage;

class SasayakiVariable extends SasayakiProvider implements SasayakiInterface
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
    protected $pattern = "/\@([a-z\_][a-z0-9\_\.]+[a-z\_])\;/i";
    
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
        $this->content = HTTP\Filter\RegExp::replace( $this->pattern, $content, function( $m ) use( $data ) {
            $result = [
                
                // Var Name.
                'name' => $m[1],
                
                // Var Value.
                'values' => Null
            ];
            if( count( $expl = explode( ".", $m[1] ) ) !== 1 )
            {
                $result['values'] = AoE\Arrayable::ify( $expl, $data );
            } else {
                if( isset( $data[$m[1]] ) )
                {
                    $result['values'] = $data[$m[1]];
                } else {
                    $result['values'] = $m[0];
                }
            }
            return( AoE\Stringable::parse( ( $this->result[] = $result )['values'] ) );
        });
    }
    
}

?>