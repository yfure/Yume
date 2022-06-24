<?php

namespace Yume\Kama\Obi\AoE;

use Iterator;

class Collection implements Buffer\Hairetsu, Iterator
{
    
    use Buffer\Iterator;
    
    /*
     * @inheritdoc Hairetsu
     */
    public function __construct( Array $data = [] )
    {
        // Set Array element.
        $this->data = $data;
        
        // Set Position to zero.
        $this->position = 0;
    }
    
}

?>