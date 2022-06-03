<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;

class PSTraceWeb
{
    
    /*
     * The WebColor Instance.
     *
     * @access Public, Readonly
     *
     * @values Yume\Kama\Obi\Exception\PSTrace\PSTraceWebColor
     */
    public /** Readonly */ PSTraceWebColor $color;
    
    /*
     * The Tree Instance.
     *
     * @access Public, Readonly
     *
     * @values Yume\Kama\Obi\AoE\Tree
     */
    public /* Readonly */ String $tree;
    
    /*
     * Stack Trace String.
     *
     * @access Public, Readonly
     *
     * @values String
     */
    public /* Readonly */ String $result;
    
    public function __construct( private /** Readonly */ PSTraceProvider $pstrace )
    {
        
        // Tree Key Event Handler.
        $this->key = fn( $key ) => PSTraceFilter::keyword( "key", $key, $this->color );
        
        // Tree Value Event Handler.
        $this->val = fn( $key, $val, $type ) => PSTraceFilter::keyword( "val.{$key}", $val, $this->color );
        
        // Create Web Color Instance.
        $this->color = new PSTraceWebColor;
        
        // Create new Tree Structure.
        $this->tree = AoE\Tree::tree( $pstrace->getTraces(), key: $this->key, val: $this->val );
        
        $this->result = view( "/system/builtin/Util/Exception/PSTrace/views/web", new AoE\Data([
            
            // Get Exception class name.
            'class' => $this->pstrace->getObject()::class,
            
            // Get Exception trace as string.
            'traces' => HTTP\Filter\RegExp::replace( "/\n/", $this->tree, "<br/>" )
            
        ]));
        
    }
    
}

?>