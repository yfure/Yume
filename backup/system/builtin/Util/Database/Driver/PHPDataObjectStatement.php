<?php

namespace Yume\Kama\Obi\Database\Driver;

use Yume\Kama\Obi\AoE;

use PDO;
use PDOStatement;

final class PHPDataObjectStatement extends PDOStatement
{
    
    public function fetchAssoc()
    {
        return( $this->fetchAll( PDO::FETCH_ASSOC ) );
    }
    
    public function fetchResult()
    {
        $result = [];
        $fetchs = $this->fetchAssoc();
        
        foreach( $fetchs As $row => $col )
        {
            $result[$row] = new AoE\Data( $col );
        }
        
        return( new AoE\Data( $result ) );
        
    }
    
}

?>