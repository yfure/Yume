<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;

class PSTraceCli
{
    
    /*
     * The WebColor Instance.
     *
     * @access Public, Readonly
     *
     * @values Yume\Kama\Obi\Exception\PSTraceCliColor
     */
    public /** Readonly */ PSTraceCliColor $color;
    
    /*
     * The Tree Instance.
     *
     * @access Public, Readonly
     *
     * @values Yume\Kama\Obi\AoE\Tree
     */
    public /* Readonly */ AoE\Tree $tree;
    
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
        $this->key = fn( $key ) => $this->color->create( $key, "key" );
        
        // Tree Value Event Handler.
        $this->val = fn( $key, $val, $type ) => $this->color->create( str_replace( BASE_PATH, "", "{$val}" ), "val" );
        
        // Create Web Color Instance.
        $this->color = new PSTraceCliColor;
        
        // Create new Tree Structure.
        $this->tree = new AoE\Tree( $pstrace->getTraces(), key: $this->key, val: $this->val );
        
        $this->result = view( "/system/builtin/Util/Exception/PSTrace/views/cli", new AoE\Data([
            
            // Get Exception class name.
            'class' => $this->pstrace->getObject()::class,
            
            // Get Exception trace as string.
            'traces' => $this->tree->getResult()
            
        ]));
        
    }
    
}

?>