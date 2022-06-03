<?php

namespace Yume\Kama\Obi\Database;

use Iterator;

class Result implements Iterator
{
    
    use \Yume\Kama\Obi\Database\Traits\Fetch;
    use \Yume\Kama\Obi\AoE\Iterator;
    
    public function __construct( ?Statement $stmt = Null, ?Array $result = Null )
    {
        // Result Set from fetch.
        $this->array = $result;
        
        // Set Position to zero.
        $this->position = 0;
        
        // Set PDO Statement Instance Class.
        $this->stmt = $stmt;
    }
    
    /*
     * Get value element.
     *
     * @return Mixed
     */
    public function row(): Mixed
    {
        return( $this->array[$this->position] );
    }
    
}

?>