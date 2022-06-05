<?php

namespace Yume\Kama\Obi\AoE;

use ArrayAccess;
use Countable;
use Iterator;

class Data extends Collection implements ArrayAccess, Countable, Buffer\Hairetsu, Iterator
{
    
    use Buffer\Access;
    use Buffer\Countable;
    use Buffer\Overloader;
    
    /*
     * @inheritdoc Yume\Kama\Obi\AoE\Buffer\Hairetsu
     */
    public function __construct( Array $data = [] )
    {
        parent::__construct( $data );
    }
    
}

?>