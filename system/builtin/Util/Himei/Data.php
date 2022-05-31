<?php

namespace Yume\Util\Himei;

class Data extends Collection implements \ArrayAccess, \Countable, Hairetsu, \Iterator
{
    
    use Access;
    use Countable;
    use Overloading;
    
    /*
     * @inheritdoc Hairetsu
     */
    public function __construct( Array $data = [] )
    {
        parent::__construct( $data );
    }
    
}

?>
