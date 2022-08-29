<?php

namespace Yume\Kama\Obi\Database\Traits;

use Yume\Kama\Obi\Database;

trait Fetch
{
    /*
     * PDO Statement Instance Class.
     *
     * @values \Yume\Kama\Obi\Database\Statement
     */
    protected $stmt;
    
    /*
     * Get PDO Statement Instance Class.
     *
     * @return \Yume\Kama\Obi\Database\Statement
     */
    public function getStmt(): Database\Statement
    {
        return( $this->stmt );
    }
    
}

?>