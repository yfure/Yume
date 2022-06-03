<?php

namespace Yume\Kama\Obi\Database;

use PDO;
use PDOStatement;

use stdClass;

class Statement extends PDOStatement
{
    /* Set the rule of fetchAll. Values will be returned as PDO::FETCH_ASSOC in fetch_array and fetch_assoc functions */
    public function fetchAssoc()
    {
        return $this->fetchAll( PDO::FETCH_ASSOC );
    }
    public function fetchResult(): Result | False
    {
        $result = [];
        $assoc = $this->fetchAssoc();
        
        foreach( $assoc As $i => $array )
        {
            $result[$i] = new stdClass;
            
            foreach( $array As $col => $val )
            {
                $result[$i]->{ $col } = $val;
            }
        }
        
        return( new Result( $this, $result ) );
    }
    /* Return number of rows */
    public function numRows()
    {
        return $this->rowcount();
    }
    /* Return affected wors */
    public function affectedRows()
    {
        return $this->rowcount();
    }
}

?>