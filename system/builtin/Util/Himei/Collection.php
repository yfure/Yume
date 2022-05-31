<?php

namespace Yume\Util\Himei;

class Collection implements Hairetsu, \Iterator
{
    
    use Iterator;
    
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
